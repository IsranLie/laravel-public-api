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
Route::get('/post-create', [PostController::class, 'create'])->name('post.create');
Route::post('/post-store', [PostController::class, 'store'])->name('post.store');
Route::get('/post-edit/{id}', [PostController::class, 'edit'])->name('post.edit');
Route::put('/post-update/{id}', [PostController::class, 'update'])->name('post.update');
Route::delete('/post-delete/{id}', [PostController::class, 'delete'])->name('post.delete');

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/user-profile/{id}', [UserController::class, 'show'])->name('user.profile');
