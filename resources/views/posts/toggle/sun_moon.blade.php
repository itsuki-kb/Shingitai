@php
$defaultCondition = old($name, 'true');; // default = 陽(True)
@endphp

<div x-data="{ condition: '{{ $defaultCondition }}' }" class="flex">

    {{-- Hidden input to send actual value --}}
    {{-- $name で、心技体それぞれの名前を受け取る --}}
    <input type="hidden" name="{{ $name }}" x-model="condition" x-bind:value="condition">

    <div class="flex space-x-2">
        {{-- 🌞 Sun button (TRUE) --}}
        <button type="button"
            @click="condition = 'true'"
            :class="condition === 'true' ? 'bg-yellow-400 text-white' : 'bg-gray-200 text-gray-500'"
            class="w-8 h-8 rounded-full flex items-center justify-center shadow transition duration-200"
        >
            <i class="fas fa-sun text-md"></i>
        </button>

        {{-- 🌙 Moon button (FALSE) --}}
        <button type="button"
            @click="condition = 'false'"
            :class="condition === 'false' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'"
            class="w-8 h-8 rounded-full flex items-center justify-center shadow transition duration-200"
        >
            <i class="fas fa-moon text-md"></i>
        </button>
    </div>

        @error('{{ $name }}')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
</div>
