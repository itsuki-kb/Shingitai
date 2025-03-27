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
                <p class="text-md font-semibold text-stone-700">
                    <a href="{{ route('profile.show', $post->user_id) }}">
                        {{ $post->user->name }}
                    </a>
                </p>
            </div>
            <div class="flex justify-between pt-4">
                {{-- Likes --}}
                <div class="flex items-center me-3">
                    <x-posts.likes :post="$post" :liked_post_ids="$liked_post_ids"/>
                </div>

                {{-- アクションボタン --}}
                @if ($post->user_id === Auth::id())
                    <div class="flex text-end space-x-2 items-center">
                        <a href="{{ route('post.edit', $post->id) }}"
                            class="inline-flex items-center px-3 py-1 bg-stone-400 text-white rounded shadow hover:bg-stone-300 text-sm">
                            <i class="fas fa-pen"></i>
                        </a>

                        <button
                        x-data
                        x-on:click="$dispatch('open-modal', 'delete-post-{{ $post->id }}')"
                        class="inline-flex items-center px-3 py-1 bg-rose-600 text-white rounded shadow hover:bg-rose-700 text-sm"
                        >
                            <i class="fas fa-trash-alt"></i>
                        </button>

                        {{-- モーダル読み込み --}}
                        <x-posts.modal.delete :post="$post" />
                    </div>
                @endif
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





    {{-- Comment Form --}}
    <form action="{{ route('comment.store', $post->id) }}" method="post" class="mt-6">
        @csrf

        <div class="flex items-center gap-2">
            <input type="text" name="comment" id="comment" maxlength="500" class="flex-1 border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400" placeholder="コメントを入力...(500文字以内)" value="{{ old('comment') }}">
            <button type="submit" class="px-4 py-2 text-sm bg-stone-200 hover:bg-stone-300 text-stone-800 rounded-md shadow-sm">送信</button>
        </div>

        {{-- Error --}}
        @error('comment')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </form>

    {{-- Display all the comments here --}}
    @if ($post->comments)
        <div class="mt-4 space-y-3 max-h-80 overflow-y-auto pr-2">
            @foreach ($post->comments as $comment)
                <div class="bg-stone-50 border border-stone-200 rounded-md p-4 flex justify-between items-start">
                    <div class="flex-1">
                        <div class="text-sm font-semibold text-stone-700">
                            <a href="{{ route('profile.show', $comment->user_id) }}">
                                {{ $comment->user->name }}
                            </a>
                        </div>
                        <div class="text-xs text-stone-400 mb-1">{{ $comment->created_at }}</div>
                        <p class="text-sm text-stone-800 mb-0">{{ $comment->content }}</p>
                    </div>
                    @if ($comment->user_id == Auth::user()->id)
                        <form action="{{ route('comment.delete', $comment->id) }}" method="post" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif









</x-app-layout>
