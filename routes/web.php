<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

// Public Routes (Accessible by anyone)
// This will be your application's homepage, displaying a list of posts.
Route::get('/', [PostController::class, 'index'])->name('home');

// Route to view a single post by its unique slug.
Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');


// Authenticated Routes (Accessible only to logged-in users)
Route::middleware('auth')->group(function () {

    // Dashboard Route
    // This route is typically the first page a user sees after logging in.
    // The 'verified' middleware ensures their email address has been confirmed.
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Profile Management Routes
    // Routes for editing, updating, and deleting the user's profile.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post Management Routes
    // Routes for authenticated users to create, store, edit, update, and delete their blog posts.
    // Remember to implement authorization checks (e.g., using Policies) in your PostController
    // to ensure users can only manage their own posts.
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // Use PUT for updates
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

});

// Laravel Breeze Authentication Routes
// This line includes all the default routes for login, registration, password reset, etc.
// It should be placed only once at the end of your web.php file.
require __DIR__.'/auth.php';