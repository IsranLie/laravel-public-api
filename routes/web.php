<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/post-detail/{id}', [PostController::class, 'show'])->name('post.detail');

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/user-profile/{id}', [UserController::class, 'show'])->name('user.profile');
