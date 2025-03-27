@php
    $existingPostsJson = json_encode($existingPosts);

    $presetDate = old('date', isset($post) ? $post->date : now()->toDateString());
@endphp

<div x-data="{
    selectedDate: '{{ $presetDate }}',
    existingPosts: {{ $existingPostsJson }},
    showModal: false,
    postId: null
}">

    <label for="date" class="block text-sm font-medium text-stone-700">日付</label>
    <input
        type="date"
        name="date"
        id="date"
        x-model="selectedDate"
        @change="
            {{-- 選択した日付が、投稿済みポストの日付と合致するかとboolean判定 --}}
            const match = existingPosts.find(post => post.date === selectedDate);
            if (match) {
                postId = match.id;
                showModal = true;
            } else {
                showModal = false;
                postId = null;
            }
        "
        class="mt-1 block w-full rounded-md border-stone-300 shadow-sm"
    />

    <template x-if="showModal">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow max-w-sm w-full">
                <p class="text-center font-semibold mb-4">⚠️この日はすでに投稿があります。</p>
                <div class="flex justify-center space-x-4">
                    <a :href="`/post/${postId}/edit`" class="bg-amber-500 text-white px-4 py-2 rounded">編集する</a>
                    <button @click="showModal = false" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">キャンセル</button>
                </div>
            </div>
        </div>
    </template>

    @error('date')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror

</div>
