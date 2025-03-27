@props(['all_listing_data', 'liked_post_ids'])

@forelse ($all_listing_data as $post)
    <div class="bg-stone-50 border border-stone-200 rounded-xl p-6 mb-6 shadow-sm w-full min-w-[640px]">
        {{-- Header --}}
        <div class="flex justify-start items-end mb-3 ms-2">
            <span class="flex me-4">{{ $post->date }}</span>

            <a href="{{ route('profile.show', $post->user_id) }}" class="flex items-end">
                @if ($post->user->avatar)
                    <img src="{{ asset('storage/' . $post->user->avatar) }}"
                    alt="{{ $post->user->name }}"
                    class="flex me-1 w-[30px] rounded-full border border-gray-300 object-cover aspect-square">
                @else
                    <div class="w-[30px] rounded-full justify-center items-center bg-gray-100 border border-dashed border-gray-300 aspect-square">
                        <i class="flex fa-solid fa-image text-6xl text-gray-400"></i>
                    </div>
                @endif
                <span class="flex">{{ $post->user->name }}</span>
            </a>
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
@empty
    <div class="text-center mt-20">
        <h2 class="text-gray-500 text-lg">投稿はまだありません。</h2>
    </div>
@endforelse
