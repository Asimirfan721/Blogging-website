<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'My Personal Blog') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else

        @endif
    </head>
    <body class="bg-yellow-100 dark:bg-yellow-900 text-[#1b1b18] flex flex-col min-h-screen">
        <!-- Header with Navigation -->
        <header class="w-full bg-white dark:bg-[#161615] shadow-sm border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="max-w-6xl mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <!-- Category Navigation -->
                    <nav class="flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-[#f53003] dark:text-[#FF4433]">
                            BlogSite
                        </a>
                        <div class="hidden md:flex space-x-6">
                            <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] transition-colors">
                                Technology
                            </a>
                            <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] transition-colors">
                                History
                            </a>
                            <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] transition-colors">
                                Future
                            </a>
                            <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] transition-colors">
                                Religious
                            </a>
                        </div>
                    </nav>

                    <!-- Auth Navigation -->
                    @if (Route::has('login'))
                        <nav class="flex items-center gap-4">
                            @auth
                                <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-[#f53003] hover:bg-[#d42802] text-white rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150">
                                    Create Post
                                </a>
                                <a href="{{ route('dashboard') }}" class="inline-block px-4 py-2 text-[#1b1b18] dark:text-[#EDEDEC] border border-[#19140035] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-md text-sm transition-colors">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-block px-4 py-2 text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#f53003] dark:hover:text-[#FF4433] text-sm transition-colors">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-block px-4 py-2 bg-[#f53003] hover:bg-[#d42802] text-white rounded-md text-sm font-medium transition-colors">
                                        Sign Up
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-[#4F46E5] to-[#7C3AED] py-20 px-6">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                    Create a blog<br>
                    worth sharing
                </h1>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto text-center font-bold italic" style="font-family: 'Times New Roman', serif;">
                    Get a full suite of intuitive design features and powerful marketing tools
                    to create a unique blog that leaves a lasting impression.
                </p>
                @auth
                    <a href="{{ route('posts.create') }}" class="inline-block bg-white text-[#4F46E5] px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-colors">
                        Start Blogging
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-block bg-white text-[#4F46E5] px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition-colors">
                        Start Blogging
                    </a>
                @endauth
                <p class="text-blue-200 text-sm mt-4">
                    @guest
                        Join today and start sharing your stories with the world.
                    @else
                        Ready to share your next story with the world?
                    @endguest
                </p>
            </div>
        </section>

        <!-- Blog Posts Section -->
        <main class="flex-1 w-full max-w-6xl mx-auto py-12 px-6">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Latest Blog Posts</h2>
                @auth
                    <a href="{{ route('posts.create') }}" class="text-[#f53003] dark:text-[#FF4433] hover:underline font-medium">
                        Write a post →
                    </a>
                @endauth
            </div>

            @if ($posts->isEmpty())
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">📝</div>
                    <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">No blog posts yet</h3>
                    <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">Be the first to share your story!</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="inline-block bg-[#f53003] hover:bg-[#d42802] text-white px-6 py-3 rounded-md font-medium transition-colors">
                            Create Your First Post
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-block bg-[#f53003] hover:bg-[#d42802] text-white px-6 py-3 rounded-md font-medium transition-colors">
                            Join to Start Blogging
                        </a>
                    @endauth
                </div>
            @else
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <article class="bg-white dark:bg-[#161615] rounded-xl shadow-sm hover:shadow-md transition-shadow p-6 border border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-3 leading-tight">
                                <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-[#f53003] dark:hover:text-[#FF4433] transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <div class="flex items-center text-[#706f6c] dark:text-[#A1A09A] text-sm mb-4">
                                <span>By {{ $post->user->name }}</span>
                                <span class="mx-2">•</span>
                                <time>{{ $post->created_at->format('M d, Y') }}</time>
                            </div>
                            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4 leading-relaxed">
                                {{ Str::limit($post->content, 150) }}
                            </p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-[#f53003] dark:text-[#FF4433] hover:underline font-medium text-sm">
                                Read more
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </article>
                    @endforeach
                </div>

                @if ($posts->hasPages())
                    <div class="mt-12">
                        {{ $posts->links('pagination::tailwind') }}
                    </div>
                @endif
            @endif
        </main>

        <!-- Footer -->
        <footer class="bg-[#1b1b18] dark:bg-[#161615] text-white py-8 px-6 mt-auto">
            <div class="max-w-6xl mx-auto text-center">
                <p class="text-[#A1A09A]">
                    © {{ date('Y') }} {{ config('app.name', 'My Personal Blog') }}. Made with ❤️ using Laravel.
                </p>
            </div>
        </footer>
    </body>
</html>