<?php
// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str for slug generation
use Illuminate\Validation\ValidationException; // Import for validation exceptions
use Illuminate\Support\Facades\Auth; // Import Auth for current user

class PostController extends Controller
{
    /**
     * Display a listing of the posts (for the homepage).
     */
    public function index()
    {
        // Fetch only published posts, ordered by creation date descending
        $posts = Post::with('user') // Eager load the user relationship to get author's name
                     ->where('status', 'published')
                     ->latest() // Orders by 'created_at' in descending order
                     ->paginate(10); // Paginate results for better performance

        return view('welcome', compact('posts')); // Pass posts to the welcome view
    }

    /**
     * Show the form for creating a new post.
     * This method requires authentication.
     */
    public function create()
    {
         
        return view('posts.create'); // Points to resources/views/posts/create.blade.php
    }

    /**
     * Store a newly created post in storage.
     * This method requires authentication.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            // Generate a unique slug from the title
            $slug = Str::slug($validatedData['title']);
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            // Create the post
            Post::create([
                'user_id' => Auth::id(), // Assign the authenticated user's ID
                'title' => $validatedData['title'],
                'slug' => $slug,
                'content' => $validatedData['content'],
                'status' => 'published', // Automatically publish for now, can be 'draft'
            ]);

            // Redirect back to the dashboard with a success message
            return redirect()->route('dashboard')->with('success', 'Post created successfully!');

        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Display the specified post.
     * This method is public (no authentication required)
     */
    public function show(Post $post) // Route model binding automatically fetches the post by slug or ID
    {
        // If you only want published posts to be accessible publicly by slug:
        if ($post->status !== 'published' && (!Auth::check() || Auth::id() !== $post->user_id)) {
            abort(404); // Or redirect to a login page
        }

        return view('posts.show', compact('post')); // Pass the post object to the view
    }

    // You can add edit and delete methods here later if needed
}