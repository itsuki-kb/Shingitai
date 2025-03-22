

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-800 tracking-widest border-b-2 border-amber-500 pb-2">
            全ての投稿一覧 🌿
        </h1>
    </x-slot>

    {{-- 投稿完了メッセージ --}}
    @if (session('success'))
        <div class="my-4 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-md shadow-sm">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @forelse ($all_posts as $post)
        <div class="bg-stone-50 border border-stone-200 rounded-xl p-6 mb-6 shadow-sm w-full">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-3">
                <div class="text-stone-600 text-sm">
                    📅 {{ $post->date }}  👤 {{ $post->user->name }}
                </div>
            </div>

            {{-- 心技体：横並び表示 --}}
            <div class="flex flex-col md:flex-row gap-4">
                @foreach ($post->elements as $element)
                    <div class="flex-1 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
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
                    </div>
                @endforeach
            </div>

            {{-- アクションボタン --}}
            @if ($post->user_id === Auth::id())
                <div class="mt-4 text-end space-x-2">
                    <a href="{{ route('post.edit', $post->id) }}"
                        class="inline-flex items-center px-4 py-1 bg-amber-600 text-white rounded shadow hover:bg-amber-700 text-sm">
                        <i class="fas fa-pen mr-1"></i> 編集
                    </a>

                    <button data-bs-toggle="modal" data-bs-target="#delete-post-{{ $post->id }}"
                        class="inline-flex items-center px-4 py-1 bg-rose-600 text-white rounded shadow hover:bg-rose-700 text-sm">
                        <i class="fas fa-trash-alt mr-1"></i> 削除
                    </button>

                    {{-- モーダル読み込み（後で有効化） --}}
                    {{-- @include('posts.modal.delete') --}}
                </div>
            @endif
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
