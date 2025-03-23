@props(['post'])

<x-modal name="delete-post-{{ $post->id }}" :show="false" max-width="md">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">本当に削除しますか？</h2>

        <p class="text-sm text-gray-600 mb-6">
            この投稿は完全に削除されます。元には戻せません。
        </p>

        <div class="flex justify-end space-x-2">
            <button
                x-on:click="$dispatch('close-modal', 'delete-post-{{ $post->id }}')"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
            >
                キャンセル
            </button>

            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700">
                    削除する
                </button>
            </form>
        </div>
    </div>
</x-modal>
