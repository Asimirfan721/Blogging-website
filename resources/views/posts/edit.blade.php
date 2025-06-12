@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="content">Content</label>
            <textarea name="content" id="content" rows="8" class="w-full border-gray-300 rounded p-2" required>{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-500">Update Post</button>
            <a href="{{ route('posts.show', $post->id) }}" class="text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
