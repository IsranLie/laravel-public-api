<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\RequestException;
use Illuminate\Pagination\LengthAwarePaginator;

class PostController extends Controller
{
    public function index()
    {
        $title = "Posts";
        $data = [];

        try {
            $users = Cache::remember('jsonplaceholder_users', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/users')
                    ->throw()
                    ->json();
            });

            $posts = Cache::remember('jsonplaceholder_all_posts', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/posts')
                    ->throw()
                    ->json();
            });

            $allComments = Cache::remember('jsonplaceholder_all_comments', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/comments')
                    ->throw()
                    ->json();
            });

            $commentCounts = collect($allComments)
                ->groupBy('postId')
                ->map(fn($group) => count($group));

            $usersById = collect($users)->keyBy('id');

            $allData = collect($posts)
                // ->shuffle()
                // ->values()
                ->map(function ($post) use ($usersById, $commentCounts) {
                    $user = $usersById->get($post['userId']);
                    $commentCount = $commentCounts->get($post['id'], 0);

                    return array_merge($post, [
                        'author_id'     => $user['id'] ?? 'Unknown',
                        'author_name'     => $user['name'] ?? 'Unknown',
                        'author_username' => $user['username'] ?? 'Unknown',
                        'comment_count'   => $commentCount,
                        'image_url'       => "https://picsum.photos/id/{$post['id']}/300/300",
                    ]);
                });

            // FILTER
            $searchId = request('search_id');
            $searchUser = request('search_user');
            $search     = request('search');

            if ($searchId) {
                $allData = $allData->where('id', (int)$searchId);
            }

            if ($searchUser) {
                $allData = $allData->filter(function ($item) use ($searchUser) {
                    return stripos($item['author_name'], $searchUser) !== false;
                });
            }

            if ($search) {
                $allData = $allData->filter(function ($item) use ($search) {
                    return stripos($item['title'], $search) !== false || stripos($item['body'], $search) !== false;
                });
            }

            // PAGINATION
            $perPage = 10;
            $currentPage = request()->get('page', 1);
            $currentItems = $allData->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $data = new LengthAwarePaginator(
                $currentItems,
                $allData->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url()]
            );
        } catch (RequestException $e) {
            Log::error("HTTP Request failed: " . $e->getMessage());
        }

        return view('post/post', compact('title', 'data'));
    }

    public function show($id)
    {
        $title = "Post Detail";
        $postData = null;
        $comments = [];

        try {
            // Get single post
            $post = Cache::remember("jsonplaceholder_post_{$id}", 3600, function () use ($id) {
                return Http::retry(3, 200)
                    ->get("https://jsonplaceholder.typicode.com/posts/{$id}")
                    ->throw()
                    ->json();
            });

            if (!$post || !isset($post['userId'])) {
                abort(404, 'Post not found');
            }

            // Get post author
            $user = Cache::remember("jsonplaceholder_user_{$post['userId']}", 3600, function () use ($post) {
                return Http::retry(3, 200)
                    ->get("https://jsonplaceholder.typicode.com/users/{$post['userId']}")
                    ->throw()
                    ->json();
            });

            // Get comments
            $comments = Cache::remember("jsonplaceholder_comments_post_{$id}", 3600, function () use ($id) {
                return Http::retry(3, 200)
                    ->get("https://jsonplaceholder.typicode.com/posts/{$id}/comments")
                    ->throw()
                    ->json();
            });

            // Merge post + author + image
            $postData = array_merge($post, [
                'author_name'     => $user['name'] ?? 'Unknown',
                'author_username' => $user['username'] ?? 'Unknown',
                'image_url'       => "https://picsum.photos/id/{$post['id']}/800/600",
            ]);
        } catch (RequestException $e) {
            Log::error("HTTP Request failed: " . $e->getMessage());
            abort(500, "failed to process data.");
        }

        return view('post/post_detail', compact('title', 'postData', 'comments'));
    }

    public function create()
    {
        $title = 'Post Create';

        $users = Cache::remember('jsonplaceholder_users', 3600, function () {
            return Http::retry(3, 200)
                ->get('https://jsonplaceholder.typicode.com/users')
                ->throw()
                ->json();
        });

        return view('post/post_create', compact('title', 'users'));
    }

    public function store(Request $request)
    {
        // Validasi form
        $validated = $request->validate([
            'user' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Kirim data ke API eksternal
        $response = Http::post('https://jsonplaceholder.typicode.com/posts', [
            'title'  => $validated['title'],
            'body'   => $validated['content'],
            'userId' => $validated['user'],
        ]);

        // Ambil respons JSON
        $data = $response->json();

        return redirect()->route('posts')
            ->with('success', 'Post sent sucessfully. Id: ' . $data['id'] . ' Title: ' . $data['title']);
    }

    public function edit($id)
    {
        $title = 'Post Update';

        try {
            // Ambil post
            $post = Cache::remember("jp_post_{$id}", 3600, function () use ($id) {
                $response = Http::retry(3, 200)
                    ->timeout(5)
                    ->acceptJson()
                    ->get("https://jsonplaceholder.typicode.com/posts/{$id}");

                if ($response->status() === 404 || blank($response->json())) {
                    abort(404, 'Post not found');
                }

                return $response->throw()->json();
            });

            // Ambil semua users
            $users = Cache::remember('jp_users', 3600, function () {
                return Http::retry(3, 200)
                    ->timeout(5)
                    ->acceptJson()
                    ->get("https://jsonplaceholder.typicode.com/users")
                    ->throw()
                    ->json();
            });
        } catch (\Throwable $e) {
            Log::error('Failed process data: ' . $e->getMessage());
            return redirect()
                ->route('posts')
                ->with('error', 'Failed process data: ' . $e->getMessage());
        }

        return view('post/post_create', compact('title', 'users', 'post'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user' => 'required|integer',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            Http::put("https://jsonplaceholder.typicode.com/posts/{$id}", [
                'id'     => $id,
                'title'  => $validated['title'],
                'body'   => $validated['content'],
                'userId' => $validated['user'],
            ])->throw()->json();

            return redirect()->route('posts')
                ->with('success', "Post Id: '{$id}' Title: '{$validated['title']}' has been updated.");
        } catch (\Throwable $e) {
            return redirect()->route('posts')
                ->with('error', 'Failed update post: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Http::delete("https://jsonplaceholder.typicode.com/posts/{$id}");

            return redirect()->route('posts')
                ->with('success', "Post Id: '{$id}' has been deleted.");
        } catch (\Throwable $e) {
            return redirect()->route('posts')
                ->with('error', 'Failed delete post: ' . $e->getMessage());
        }
    }
}
