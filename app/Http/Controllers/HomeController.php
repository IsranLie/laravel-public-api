<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Home";
        $data = [];

        try {
            // Cache users 1 jam
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

            $usersById = collect($users)->keyBy('id');

            // Gabungkan data author & image URL
            $allData = collect($posts)
                ->shuffle()
                ->values()
                ->map(function ($post) use ($usersById) {
                    $user = $usersById->get($post['userId']);
                    return array_merge($post, [
                        'author_name'     => $user['name'] ?? 'Unknown',
                        'author_username' => $user['username'] ?? 'Unknown',
                        'image_url'       => "https://picsum.photos/seed/{$post['id']}/400/300",
                    ]);
                });

            // PAGINATION MANUAL
            $perPage = 10; // jumlah item per halaman
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

        return view('home', compact('title', 'data'));
    }
}
