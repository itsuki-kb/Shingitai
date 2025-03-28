@props(['all_listing_data'])

{{-- <div class="bg-stone-50 border border-stone-200 rounded-xl p-6 mb-6 shadow-sm w-full min-w-[640px]"> --}}
@forelse ($all_listing_data as $listed_user)
    <div class="flex items-center space-x-4 p-4 bg-white border border-stone-200 rounded-md shadow-sm">
        {{-- Avatar --}}
        @if ($listed_user->avatar)
            <img src="{{ asset('storage/' . $listed_user->avatar) }}"
                alt="{{ $listed_user->name }}"
                class="w-12 h-12 rounded-full object-cover">
        @else
            <div class="w-12 h-12 rounded-full bg-stone-200 flex items-center justify-center text-stone-500 text-xl">
                <i class="fa-solid fa-user"></i>
            </div>
        @endif

        {{-- Name & Profile --}}
        <div class="flex-1 min-w-0">
            <a href="{{ route('profile.show', $listed_user->id) }}"
            class="text-base font-semibold text-stone-800 hover:underline">
                {{ $listed_user->name }}
            </a>
            <p class="text-sm text-stone-600 line-clamp-2">
                {{ $listed_user->profile ?? '' }}
            </p>
        </div>
    </div>
@empty
    <div class="text-center mt-20">
        <h2 class="text-stone-500 text-md">表示できるユーザーがいません。</h2>
    </div>
@endforelse
