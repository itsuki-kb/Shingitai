<x-app-layout>
    {{-- タブ --}}
    <div class="flex gap-4 text-sm mb-4">
        <a href="{{ route('post.index') }}?tab=all_posts"
           class="{{ $tab === 'all_posts' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
           All Posts
        </a>
        <a href="{{ route('post.index') }}?tab=following_posts"
           class="{{ $tab === 'following_posts' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
           Following Posts
        </a>
    </div>

    {{-- 投稿一覧 --}}
    <div class="mt-4 space-y-3 h-[75vh] overflow-y-auto pt-4 py-2 pr-2 border-t-8 border-black-500 border-double">
        @include('components.posts.post-list', [
            'all_listing_data' => $all_listing_data,
            'liked_post_ids' => $liked_post_ids
        ])
    </div>

    <div class="mt-2 mb-2">
        {{ $all_listing_data->links() }}
    </div>

</x-app-layout>
