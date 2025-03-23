@php
    //心技体のconditionをtrue(1)と前提し、DBから取得したデータがfalse(0)なら以下でそれぞれ変更する
    $stored_condition = 'true';

    if ($name === 'heart_condition' && $conditions[0] == 0) {
        $stored_condition = 'false';
    }

    if ($name === 'skill_condition' && $conditions[1] == 0) {
        $stored_condition = 'false';
    }

    if ($name === 'body_condition' && $conditions[2] == 0) {
        $stored_condition = 'false';
    }
    // 新たに入力した値がない限り、データベースの値が適用される
    $defaultCondition = old($name, $stored_condition);

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

</div>
