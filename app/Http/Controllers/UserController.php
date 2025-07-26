<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\RequestException;

class UserController extends Controller
{
    public function index()
    {
        $title = "Users";
        try {
            $users = Cache::remember('jsonplaceholder_users', 3600, function () {
                return Http::retry(3, 200)
                    ->get('https://jsonplaceholder.typicode.com/users')
                    ->throw()
                    ->json();
            });

            $data = collect($users)->map(function ($user) {
                $user['image_url'] = "https://picsum.photos/id/{$user['id']}/300/300";
                return $user;
            })->toArray();
        } catch (RequestException $e) {
            Log::error("HTTP Request gagal: " . $e->getMessage());
            $data = [];
        }

        return view('user/user', compact('title', 'data'));
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
            Log::error("HTTP Request gagal: " . $e->getMessage());
        }

        return view('user/user_profile', compact('title', 'user', 'posts'));
    }
}
