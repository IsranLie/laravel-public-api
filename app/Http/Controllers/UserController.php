<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\RequestException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $title   = "Users";
        $search  = trim($request->get('search', ''));
        $sort    = $request->get('sort', 'name_asc');
        $perPage = (int) $request->get('per_page', 10);

        try {
            // Ambil semua users
            $users = Cache::remember('jsonplaceholder_users', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/users')
                    ->throw()
                    ->json();
            });

            // Ambil semua posts
            $posts = Cache::remember('jsonplaceholder_posts', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/posts')
                    ->throw()
                    ->json();
            });

            // Hitung jumlah post per userId
            $postCounts = collect($posts)
                ->groupBy('userId')
                ->map(fn($group) => $group->count());

            // Gabungkan data jumlah post ke user
            $data = collect($users)->map(function ($user) use ($postCounts) {
                $user['image_url']  = "https://picsum.photos/id/{$user['id']}/300/300";
                $user['post_count'] = $postCounts->get($user['id'], 0);
                return $user;
            });

            // SEARCH
            if ($search !== '') {
                $needle = Str::lower($search);
                $data = $data->filter(function ($u) use ($needle) {
                    // Sesuaikan kolom yang ingin dicari
                    return Str::contains(Str::lower($u['name']), $needle)
                        || Str::contains(Str::lower($u['username']), $needle)
                        || Str::contains(Str::lower($u['email']), $needle)
                        || Str::contains(Str::lower($u['website']), $needle)
                        || (isset($u['company']['name']) && Str::contains(Str::lower($u['company']['name']), $needle));
                });
            }

            // SORT
            $sorters = [
                'name_asc'      => fn($c) => $c->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
                'name_desc'     => fn($c) => $c->sortByDesc('name', SORT_NATURAL | SORT_FLAG_CASE),
            ];

            if (isset($sorters[$sort])) {
                $data = $sorters[$sort]($data);
            }

            // Pagination manual
            $page  = (int) $request->get('page', 1);
            $total = $data->count();
            $items = $data->forPage($page, $perPage)->values();
            $data  = new LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } catch (RequestException $e) {
            Log::error("HTTP Request failed: " . $e->getMessage());
            $data = collect();
        }

        return view('user/user', [
            'title'  => $title,
            'data'   => $data,   // paginator
            'search' => $search,
            'sort'   => $sort,
        ]);
    }

    public function show($id)
    {
        $title = "User Profile";
        $user = [];
        $posts = [];
        $commentCounts = [];

        try {
            $user = Cache::remember("jsonplaceholder_user_{$id}", 3600, function () use ($id) {
                return Http::retry(3, 200)
                    ->get("https://jsonplaceholder.typicode.com/users/{$id}")
                    ->throw()
                    ->json();
            });
            $user['image_url'] = "https://picsum.photos/id/{$user['id']}/300/300";

            $posts = Http::retry(3, 200)
                ->get("https://jsonplaceholder.typicode.com/users/{$id}/posts")
                ->throw()
                ->json();

            $comments = Cache::remember('jsonplaceholder_all_comments', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/comments')
                    ->throw()
                    ->json();
            });

            $commentCounts = collect($comments)
                ->groupBy('postId')
                ->map(fn($group) => $group->count());

            $posts = collect($posts)->map(function ($post) use ($commentCounts) {
                $post['image_url'] = "https://picsum.photos/id/{$post['id']}/300/300";
                $post['comment_count'] = $commentCounts[$post['id']] ?? 0;
                return $post;
            })->all();
        } catch (RequestException $e) {
            Log::error("HTTP Request failed: " . $e->getMessage());
        }

        return view('user/user_profile', compact('title', 'user', 'posts'));
    }

    public function create()
    {
        $title = 'User Create';

        return view('user/user_create', compact('title'));
    }

    public function store(Request $request)
    {
        // Validasi form
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
        ]);

        // Kirim data ke API eksternal
        $response = Http::post('https://jsonplaceholder.typicode.com/users', [
            'name'  => $validated['name'],
            'username'   => $validated['username'],
            'email' => $validated['email'],
        ]);

        // Ambil respons JSON
        $data = $response->json();

        return redirect()->route('users')
            ->with('success', 'Add user sucessfully. Id: ' . $data['id'] . ' Name: ' . $data['name']);
    }

    public function edit($id)
    {
        $title = 'User Update';

        try {
            // Ambil user
            $user = Cache::remember("jp_users_{$id}", 3600, function () use ($id) {
                $response = Http::retry(3, 200)
                    ->timeout(5)
                    ->acceptJson()
                    ->get("https://jsonplaceholder.typicode.com/users/{$id}");

                if ($response->status() === 404 || blank($response->json())) {
                    abort(404, 'Users not found');
                }

                return $response->throw()->json();
            });
        } catch (\Throwable $e) {
            Log::error('Failed process data: ' . $e->getMessage());
            return redirect()
                ->route('users')
                ->with('error', 'Failed process data: ' . $e->getMessage());
        }

        return view('user/user_create', compact('title', 'user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
        ]);

        try {
            Http::put("https://jsonplaceholder.typicode.com/users/{$id}", [
                'id'     => $id,
                'name'  => $validated['name'],
                'username'   => $validated['username'],
                'email' => $validated['email'],
            ])->throw()->json();

            return redirect()->route('users')
                ->with('success', "User Id: '{$id}' Name: '{$validated['name']}' has been updated.");
        } catch (\Throwable $e) {
            return redirect()->route('users')
                ->with('error', 'Failed update user: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Http::delete("https://jsonplaceholder.typicode.com/users/{$id}");

            return redirect()->route('users')
                ->with('success', "User Id: '{$id}' has been deleted.");
        } catch (\Throwable $e) {
            return redirect()->route('users')
                ->with('error', 'Failed delete user: ' . $e->getMessage());
        }
    }
}
