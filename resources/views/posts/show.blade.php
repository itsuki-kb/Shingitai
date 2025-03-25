<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 tracking-widest  pb-2">
            投稿詳細
        </h2>
    </x-slot>

    <div class="bg-stone-50 border border-stone-200 rounded-xl p-6 mb-6 shadow-sm w-full min-w-[640px]">

        {{-- 日付とユーザーとLike--}}
        <div class="flex justify-between mb-8 ps-2 pe-2">
            <div class="flex flex-col flex-start">
                <p class="text-sm text-stone-500 pb-2">{{ $post->date }}</p>
                <p class="text-md font-semibold text-stone-700">{{ $post->user->name }}</p>
            </div>
            <div class="flex content-end me-1">
                <x-posts.likes :post="$post" :liked_post_ids="$liked_post_ids"></x-posts-likes>
            </div>
        </div>

        {{-- 心技体の内容 --}}
        <div class="space-y-6">
            @foreach ($post->elements as $element)
                <div class="p-6 rounded-lg shadow-sm border border-gray-200 bg-white">
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
