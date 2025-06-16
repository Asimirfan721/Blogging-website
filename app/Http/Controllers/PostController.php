<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of published posts.
     */
    public function index()
    {
        $posts = Post::with('user')
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('welcome', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category_id' => 'required|exists:categories,id',
            ]);

            $slug = Str::slug($validatedData['title']);
            $originalSlug = $slug;
            $count = 1;

            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            Post::create([
                'user_id'     => Auth::id(),
                'title'       => $validatedData['title'],
                'slug'        => $slug,
                'content'     => $validatedData['content'],
                'status'      => 'published',
                'category_id' => $validatedData['category_id'],
            ]);

            return redirect()->route('home')->with('success', 'Post created successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post)
    {
        if (
            $post->status !== 'published' &&
            (!Auth::check() || Auth::id() !== $post->user_id)
        ) {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Display posts filtered by category.
     */
    public function byCategory($id)
    {
        $category = Category::findOrFail($id);

        $posts = Post::where('category_id', $id)
            ->where('status', 'published')
            ->latest()
            ->paginate(6);

        $categories = Category::all();

        return view('welcome', compact('posts', 'category', 'categories'));
    }
}
