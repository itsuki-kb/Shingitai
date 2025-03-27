@php
    //createでは、conditions[1,1,1](すべてtrueにプリセット)
    //editでは、DBの数値がconditions[]にセットされている

    if ($name === 'heart_condition'){
        $condition = $conditions[0];
    }

    if ($name === 'skill_condition'){
        $condition = $conditions[1];
    }

    if ($name === 'body_condition'){
        $condition = $conditions[2];
    }

    $presetCondition = old($name, $condition);

@endphp

<div x-data="{ condition: {{ $presetCondition }} }" class="flex">
    {{-- Hidden input to send actual value --}}
    <input type="hidden" name="{{ $name }}" x-model="condition" x-bind:value="condition">

    <div class="flex space-x-2">
        {{-- 🌞 Sun button (TRUE) --}}
        <button type="button"
            @click="condition = 1"
            :class="condition === 1 ? 'bg-yellow-400 text-white' : 'bg-gray-200 text-gray-500'"
            class="w-8 h-8 rounded-full flex items-center justify-center shadow transition duration-200"
        >
            <i class="fas fa-sun text-md"></i>
        </button>

        {{-- 🌙 Moon button (FALSE) --}}
        <button type="button"
            @click="condition = 0"
            :class="condition === 0 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'"
            class="w-8 h-8 rounded-full flex items-center justify-center shadow transition duration-200"
        >
            <i class="fas fa-moon text-md"></i>
        </button>
    </div>

</div>
