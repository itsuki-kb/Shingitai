@props(['post', 'liked_post_ids'])

{{--
    もしログインユーザーがポストにLIKEしていれば、赤いハートを表示
            ハートを押すと、deleteLikeメソッドが作動

        していなければ、赤枠のハートを表示
            ハートを押すと、addLikeメソッドが作動
--}}

<div x-data="likeHandler({{ $post->id }},
                         {{ in_array($post->id, $liked_post_ids) ? 'true' : 'false' }},
                         {{ $post->likes_count }})">
    <button @click="toggleLike">
        <template x-if="liked">
            <i class="fa-solid fa-heart text-rose-500 hover:text-rose-700 transition"></i>
        </template>
        <template x-if="!liked">
            <i class="fa-regular fa-heart text-rose-500 hover:text-opacity-70 transition"></i>
        </template>
    </button>

    {{-- LIKEの数を表示 --}}
    <span x-text="likeCount" class="text-sm text-gray-700"></span>
</div>


<script>
    function likeHandler(postId, initiallyLiked, initialCount) {
        return {
            //in_arrayの判定結果がinitiallyLikedとして渡され、likedに代入
            liked: initiallyLiked,
            //likes_countはinitialCountとして渡され、likeCountに代入
            likeCount: initialCount,


            toggleLike() {
                const method = this.liked ? 'DELETE' : 'POST';
                const url = `/like/${postId}`;

                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        this.liked = !this.liked;   //true or falseをトグル
                        this.likeCount += this.liked ? 1 : -1; //trueなら数字を+1
                    } else {
                        console.error('通信エラー');
                    }
                });
            }
        }
    }
</script>
