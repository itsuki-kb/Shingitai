<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 tracking-widest  pb-2">
            投稿一覧
        </h1>
    </x-slot>

    {{-- 投稿完了メッセージ --}}
    @if (session('success'))
        <div class="my-4 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-md shadow-sm">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

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
    <div class="pt-4 border-t-4 border-black-300 border-double">
        @include('components.posts.post-list', [
            'all_listing_data' => $all_listing_data,
            'liked_post_ids' => $liked_post_ids
        ])
    </div>

    <div class="mb-4">
        {{ $all_listing_data->links() }}
    </div>

</x-app-layout>
