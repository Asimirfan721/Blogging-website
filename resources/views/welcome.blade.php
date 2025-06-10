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
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen p-6 lg:p-8">
        <header class="w-full max-w-4xl mx-auto text-sm mb-6 flex justify-end">
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-1 w-full max-w-4xl mx-auto py-8">
            <h1 class="mb-8 text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] text-center">Latest Blog Posts</h1>

            @if ($posts->isEmpty())
                <p class="text-[#706f6c] dark:text-[#A1A09A] text-center">No blog posts published yet. Check back soon!</p>
            @else
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <div class="bg-white dark:bg-[#161615] rounded-lg shadow-md p-6 border border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <h2 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-[#f53003] dark:text-[#FF4433] hover:underline">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="text-[#706f6c] dark:text-[#A1A09A] text-sm mb-3">
                                Published on {{ $post->created_at->format('M d, Y') }} by **{{ $post->user->name }}**
                            </p>
                            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-4">
                                {{ Str::limit($post->content, 150) }}
                            </p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Read More &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $posts->links('pagination::tailwind') }}
                </div>
            @endif
        </main>
    </body>
</html>