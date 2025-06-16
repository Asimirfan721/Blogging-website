<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Post') }}
            <a href="/" class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm leading-normal"
                       > Home</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- ADDED: Simple test message --}}
                    <p style="color: red; font-weight: bold; text-align: center;"> </p>

                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <x-textarea id="content" class="block mt-1 w-full" name="content" rows="10" required>{{ old('content') }}</x-textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                        <div class="mt-4">
    <x-input-label for="category" :value="__('Category')" />
   <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    <option value="1">Technology</option>
    <option value="2">History</option>
    <option value="3">Future</option>
    <option value="4">Religious</option>
     
</select>

    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
</div>


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Publish Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>