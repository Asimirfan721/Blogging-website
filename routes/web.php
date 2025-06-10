<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

 
// Public Routes
// The homepage now uses the PostController to display all posts.
Route::get('/', [PostController::class, 'index'])->name('home');

// Route to view a single post by its slug.
// Ensure your PostController's show method handles published status appropriately.
Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Authenticated Routes (for logged-in users)
Route::middleware('auth')->group(function () {
    // Dashboard Route (Ensures user is authenticated and email is verified)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard'); // 'auth' middleware is already applied by the group

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post Management Routes (CRUD for authenticated users)
    // Create a new post
    Route::get('/posts/creat', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Edit an existing post (assuming you want to allow editing by authenticated users)
    // Implement authorization in your PostController to ensure only the post owner can edit.
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit'); 
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    // Delete a post (with authorization)
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Include the authentication routes provided by Laravel Breeze/Jetstream
// This should only be called ONCE.
require __DIR__.'/auth.php';