<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index()
    {
        $title = "";
        $data = [];

        try {
            // Cache users
            $users = Cache::remember('jsonplaceholder_users', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/users')
                    ->throw()
                    ->json();
            });

            // Ambil semua posts
            $posts = Http::retry(3, 200)
                ->get('https://jsonplaceholder.typicode.com/posts')
                ->throw()
                ->json();

            // Ambil semua komentar
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

            // Gabungkan data
            $allData = collect($posts)
                ->map(function ($post) use ($usersById, $commentCounts) {
                    $user = $usersById->get($post['userId']);
                    return array_merge($post, [
                        'author_name'     => $user['name'] ?? 'Unknown',
                        'author_username' => $user['username'] ?? 'Unknown',
                        'comment_count'   => $commentCounts->get($post['id'], 0),
                        'image_url'       => "https://picsum.photos/id/{$post['id']}/400/300",
                    ]);
                });

            // ===== FILTER =====
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
            Log::error("HTTP Request gagal: " . $e->getMessage());
        }

        return view('home/home', compact('title', 'data'));
    }
}
