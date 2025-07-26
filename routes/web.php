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
Route::get('/user-create', [UserController::class, 'create'])->name('user.create');
Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
Route::get('/user-edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user-update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user-delete/{id}', [UserController::class, 'delete'])->name('user.delete');
