<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-stone-700 tracking-wide  pb-1">
            新規投稿作成
        </h2>
    </x-slot>

    <form action="{{ route('post.store') }}" method="post"
        class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-md border border-stone-200 space-y-8">
        @csrf

        {{-- Date --}}
        <div>
            <label for="date" class="block text-sm font-medium text-stone-700">日付</label>
            <input
                type="date"
                name="date"
                id="date"
                value="{{ old('date') }}"
                class="mt-1 block w-full rounded-md border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-200"
            >
            @error('date')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- 心 --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="heart" class="text-md font-bold text-stone-800 ps-3">心</label>
                @include('posts.toggle.sun_moon', ['name' => 'heart_condition'])
            </div>
            <textarea
                name="heart_content"
                id="heart"
                rows="3"
                cols="100"
                placeholder="笑門来福"
                maxlength="500"
                class="w-full rounded-md border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-200"
            >{{ old('heart_content') }}</textarea>
            @error('heart_content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- 技 --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="skill" class="text-md font-bold text-stone-800 ps-3">技</label>
                @include('posts.toggle.sun_moon', ['name' => 'skill_condition'])
            </div>
            <textarea
                name="skill_content"
                id="skill"
                rows="3"
                placeholder="日進月歩"
                maxlength="500"
                class="w-full rounded-md border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-200"
            >{{ old('skill_content') }}</textarea>
            @error('skill_content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- 体 --}}
        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="body" class="text-md font-bold text-stone-800 ps-3">体</label>
                @include('posts.toggle.sun_moon', ['name' => 'body_condition'])
            </div>
            <textarea
                name="body_content"
                id="body"
                rows="3"
                placeholder="健体康心"
                maxlength="500"
                class="w-full rounded-md border-stone-300 shadow-sm focus:border-amber-500 focus:ring-amber-200"
            >{{ old('body_content') }}</textarea>
            @error('body_content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <p class="text-sm text-stone-400 ps-3">*それぞれ500文字以内で入力してください。</p>
        </div>

        {{-- Submit --}}
        <div class="text-center">
            <button type="submit"
                class="inline-block px-6 py-2 bg-amber-600 text-white rounded-md shadow hover:bg-amber-700 transition">
                <i class="fas fa-paper-plane mr-1"></i> 投稿する
            </button>
        </div>
    </form>
</x-app-layout>
