<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 tracking-widest  pb-2">
            {{ $user->name }}さんのマイページ
        </h1>
    </x-slot>

    <div class="flex flex-col sm:flex-row mt-4 mb-8 gap-6">
        {{-- アバター画像 --}}
        <div class="sm:w-1/3 w-full">
            @if ($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}"
                     alt="{{ $user->name }}"
                     class="w-full rounded-md shadow-md border border-gray-300 object-cover aspect-square">
            @else
                <div class="w-full h-full flex justify-center items-center bg-gray-100 rounded-md border border-dashed border-gray-300 aspect-square">
                    <i class="fa-solid fa-image text-6xl text-gray-400"></i>
                </div>
            @endif
        </div>

        {{-- ユーザー情報 --}}
        <div class="sm:w-2/3 w-full flex flex-col justify-center">
            <h2 class="text-2xl font-semibold text-stone-700 mb-2">{{ $user->name }}</h2>
            <p class="text-sm text-gray-600 mb-2">{{ $user->profile }}</p>
            @if ($user->id == Auth::id())
                <a href="{{ route('profile.edit', Auth::user()->id) }}"
                   class="text-indigo-600 hover:underline text-sm">
                    Edit Profile
                </a>
            @endif
        </div>
    </div>


    {{-- ユーザーの投稿を表示 --}}
    @forelse ($all_posts as $post)
        <div class="bg-stone-50 border border-stone-200 rounded-xl p-6 mb-6 shadow-sm w-full min-w-[640px]">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-3 ms-2">
                <div class="text-stone-600 text-sm">
                    📅 {{ $post->date }}  👤 {{ $post->user->name }}
                </div>
            </div>

            {{-- 心技体：横並び表示 --}}
            <div class="flex flex-col md:flex-row gap-4">
                @foreach ($post->elements as $element)
                <a href="{{ route('post.show', $post->id) }}" class='flex-1 bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:bg-gray-50'>
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold text-gray-700 tracking-wide">
                                {{ $element->category }}
                            </h3>
                            <span class="inline-flex items-center px-2 py-1 text-xs rounded-full
                                {{ $element->condition ? 'bg-amber-200 text-amber-800' : 'bg-indigo-200 text-indigo-800' }}">
                                @if ($element->condition)
                                    <i class="fas fa-sun"></i>
                                @else
                                    <i class="fas fa-moon"></i>
                                @endif
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 line-clamp-5 leading-relaxed">
                            {{ $element->content }}
                        </p>
                    </a>
                @endforeach
            </div>

            <div class="flex justify-between pt-4">
                {{-- Likes --}}
                <div class="flex items-center ms-2">
                    <x-posts.likes :post="$post" :liked_post_ids="$liked_post_ids"></x-posts-likes>
                </div>

                {{-- アクションボタン --}}
                @if ($post->user_id === Auth::id())
                    <div class="flex text-end space-x-2 items-center">
                        <a href="{{ route('post.edit', $post->id) }}"
                            class="inline-flex items-center px-4 py-1 bg-amber-600 text-white rounded shadow hover:bg-amber-700 text-sm">
                            <i class="fas fa-pen mr-1"></i> 編集
                        </a>

                        <button
                        x-data
                        x-on:click="$dispatch('open-modal', 'delete-post-{{ $post->id }}')"
                        class="inline-flex items-center px-4 py-1 bg-rose-600 text-white rounded shadow hover:bg-rose-700 text-sm"
                        >
                            <i class="fas fa-trash-alt mr-1"></i> 削除
                        </button>

                        {{-- モーダル読み込み --}}
                        <x-posts.modal.delete :post="$post" />
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center mt-40">
            <h2 class="text-gray-500 text-lg">投稿はまだありません。</h2>
            <a href="{{ route('post.create') }}" class="text-rose-600 hover:underline mt-2 inline-block">
                ➕ 新しい投稿を作成
            </a>
        </div>
    @endforelse

    <div class="mb-4">
        {{ $all_posts->links() }}
    </div>

</x-app-layout>
