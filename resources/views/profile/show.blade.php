<x-app-layout>

    <div class="flex flex-col sm:flex-row mt-4 mb-8 gap-6 h-[30vh]">
        {{-- アバター画像 --}}
        <div class="sm:w-1/4 w-full flex">
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
        <div class="sm:w-3/4 w-full flex flex-col justify-top">
            <div class="flex items-center mb-2">
                <h2 class="text-2xl font-semibold text-stone-700 me-4 inline-flex">{{ $user->name }}</h2>
                {{-- 自分のページなら、編集リンクを表示 --}}
                @if ($user->id == Auth::id())
                    <a href="{{ route('profile.edit', Auth::user()->id) }}"
                       class="text-indigo-600 hover:underline text-sm block flex-inline align-bottom">
                        Edit Profile
                    </a>
                @endif

                {{-- 自分のプロフィールページでなければ、フォローボタンを表示 --}}
                @if (Auth::id() !== $user->id)
                    <x-follows.follow-button :user="$user" />
                @endif
            </div>

            <p class="text-sm text-gray-600 mb-2">{{ $user->profile }}</p>
        </div>
    </div>

    <div class="flex gap-4 text-sm mb-2">
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
        <div class="mt-4 space-y-3 h-[45vh] overflow-y-auto pt-4 py-2 pr-2 border-t-4 border-black-300 border-double">
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
