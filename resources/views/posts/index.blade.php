<x-app-layout>
    {{-- タブ --}}
    <div class="flex justify-between gap-4 text-sm items-end">
        <div class="flex">
            <a href="{{ route('post.index') }}?tab=all_posts"
            class="me-4 {{ $tab === 'all_posts' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
                All Posts
            </a>
            <a href="{{ route('post.index') }}?tab=following_posts"
            class="{{ $tab === 'following_posts' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
                Following Posts
            </a>
        </div>
        <div class="flex">
            <form method="GET" action="{{ route('post.index') }}" class="flex space-x-2">
                {{-- タブの情報を検索時に同時に送信 --}}
                <input type="hidden" name="tab" value="{{ request('tab', 'all_posts') }}">

                <input type="text" name="keyword" value="{{ request('keyword') }}"
                       placeholder="Search..."
                       class="form-input flex-1 rounded-md border border-stone-300 px-3">
                <button type="submit" class="btn bg-green-800 text-white px-4 rounded-md shadow">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>
    </div>

    {{-- 投稿一覧 --}}
    <div class="mt-2 space-y-3 h-[75vh] overflow-y-auto pt-4 py-2 pr-2 border-t-8 border-black-500 border-double">
        @include('components.posts.post-list', [
            'all_listing_data' => $all_listing_data,
            'liked_post_ids' => $liked_post_ids
        ])
    </div>

    <div class="mt-2 mb-2">
        {{ $all_listing_data->links() }}
    </div>

</x-app-layout>
