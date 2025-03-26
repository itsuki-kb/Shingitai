@props(['all_listing_data'])

<div class="mt-4 space-y-3 max-h-screen overflow-y-auto pt-4 py-2 pr-2 border-t-4 border-black-300 border-double">
    @foreach ($all_listing_data as $listed_user)
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
    @endforeach

    @if ($all_listing_data->isEmpty())
        <p class="text-sm text-stone-500 text-center py-4">
            表示できるユーザーがいません。
        </p>
    @endif
</div>
