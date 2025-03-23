<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-stone-700 tracking-wide border-b border-amber-400 pb-1">
            {{ $post->user->name }} さんの投稿
        </h2>
    </x-slot>

    <div class="w-full max-w-3xl mx-auto min-w-[320px] bg-white mt-12 p-8 rounded-2xl shadow-sm border border-stone-200 space-y-10">

        {{-- 日付とユーザー --}}
        <div class="text-center space-y-2">
            <p class="text-sm text-stone-500">{{ \Carbon\Carbon::parse($post->date)->format('Y年n月j日') }}</p>
            <p class="text-md font-semibold text-stone-700">{{ $post->user->name }}</p>
        </div>

        {{-- 心技体の内容 --}}
        <div class="space-y-6">
            @foreach ($post->elements as $element)
                <div class="p-6 rounded-lg shadow-sm border border-stone-100 bg-stone-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-stone-800 tracking-widest">
                            {{ $element->category }}
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                            {{ $element->condition ? 'bg-amber-200 text-amber-800' : 'bg-indigo-200 text-indigo-800' }}">
                            <i class="fas {{ $element->condition ? 'fa-sun' : 'fa-moon' }}"></i>
                        </span>
                    </div>
                    <p class="text-stone-700 text-sm leading-relaxed whitespace-pre-line">
                        {{ $element->content }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
