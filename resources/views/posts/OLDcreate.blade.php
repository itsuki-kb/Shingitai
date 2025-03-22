<x-app-layout>
    <x-slot name="header">
        here create a post
    </x-slot>

    <form action="{{ route('post.store') }}" method="post" class="max-w-xl mx-auto space-y-6">
        @csrf

        {{-- Date --}}
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input
                type="date"
                name="date"
                id="date"
                value="{{ old('date') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            >
            @error('date')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contents --}}
        {{-- 心 --}}
        <div>
            <div class="flex mb-2">
                <label for="heart" class="text-sm font-bold text-gray-700 flex me-4 items-center">心</label>
                @include('posts.toggle.sun_moon', ['name' => 'heart_condition'])
            </div>

            <textarea
                name="heart_content"
                id="heart"
                rows="3"
                placeholder="Start writing..."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            >{{ old('heart_content') }}</textarea>
            @error('heart_content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- 技 --}}
        <div>
            <div class="flex mb-2">
                <label for="skill" class="text-sm font-bold text-gray-700 flex me-4 items-center">技</label>
                @include('posts.toggle.sun_moon', ['name' => 'skill_condition'])
            </div>
            <textarea
                name="skill_content"
                id="skill"
                rows="3"
                placeholder="Start writing..."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            >{{ old('skill_content') }}</textarea>
            @error('skill_content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- 体 --}}
        <div>
            <div class="flex mb-2">
                <label for="body" class="text-sm font-bold text-gray-700 flex me-4 items-center">体</label>
                @include('posts.toggle.sun_moon', ['name' => 'body_condition'])
            </div>
            <textarea
                name="body_content"
                id="body"
                rows="3"
                placeholder="Start writing..."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
            >{{ old('body_content') }}</textarea>
            @error('body_content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit Button --}}
        <div class="text-center">
            <x-primary-button type="submit">
                Post
            </x-primary-button>
        </div>

        



    </form>



</x-app-layout>
