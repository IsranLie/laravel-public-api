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
                ->shuffle()
                ->values()
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

        return view('post', compact('title', 'data'));
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
            Log::error("HTTP Request gagal: " . $e->getMessage());
            abort(500, "Gagal memuat data.");
        }

        return view('post_detail', compact('title', 'postData', 'comments'));
    }
}
