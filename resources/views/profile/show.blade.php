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
            {{-- 自分のプロフィールページでなければ、フォローボタンを表示 --}}
            @if (Auth::id() !== $user->id)
                <x-follows.follow-button :user="$user" />
            @endif
        </div>
    </div>

    <div class="flex gap-4 text-sm mb-4">
        <a href="{{ route('profile.show', $user->id) }}?tab=posts"
           class="{{ $tab === 'posts' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
           All Posts
        </a>
        <a href="{{ route('profile.show', $user->id) }}?tab=likes"
           class="{{ $tab === 'likes' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
           Likes
        </a>
        <a href="{{ route('profile.show', $user->id) }}?tab=followings"
            class="{{ $tab === 'followings' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
            Followings
         </a>
         <a href="{{ route('profile.show', $user->id) }}?tab=followers"
            class="{{ $tab === 'followers' ? 'font-bold text-stone-900' : 'text-stone-500' }}">
            Followers
         </a>
    </div>

    @if ($tab === 'posts' || $tab === 'likes')
        {{-- ユーザーの投稿を表示 --}}
        <div class="mt-4 space-y-3 max-h-screen overflow-y-auto pt-4 py-2 pr-2 border-t-4 border-black-300 border-double">
            {{-- <x-posts.post-list :all_listing_data="$all_listing_data" :liked_post_ids="$liked_post_ids" /> --}}
            @include('components.posts.post-list', [
                        'all_listing_data' => $all_listing_data,
                        'liked_post_ids' => $liked_post_ids
        ])
        </div>
    @endif

    @if (($tab === 'followings' || $tab === 'followers'))
        <x-follows.following-follower-list :all_listing_data="$all_listing_data"/>
    @endif

</x-app-layout>
