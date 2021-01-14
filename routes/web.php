<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\Residents;

Route::get('/posts', [Residents::class, 'index'])->name('home');

Route::get('/searchOnInput', [Residents::class, 'searchOnInput'])->name('searchOnInput');

Route::post('/insertRecord', [Residents::class, 'insertRecord'])->name('insertRecord');

// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->name('dashboard');

// Route::get('/users/{user:username}/posts', [UserPostController::class, 'index'])->name('users.posts');

// Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

// Route::get('/login', [LoginController::class, 'index'])->name('login');
// Route::post('/login', [LoginController::class, 'store']);

// Route::get('/register', [RegisterController::class, 'index'])->name('register');
// Route::post('/register', [RegisterController::class, 'store']);

// Route::get('/posts', [PostController::class, 'index'])->name('posts');
// Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
// Route::post('/posts', [PostController::class, 'store']);
// Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

// Route::post('/posts/{post}/likes', [PostLikeController::class, 'store'])->name('posts.likes');
// Route::delete('/posts/{post}/likes', [PostLikeController::class, 'destroy'])->name('posts.likes');

