@props(['user'])

@php
    $isFollowing = Auth::user()->followings->contains($user->id);
@endphp

{{-- json_encodeでbooleanのtrue/falseに指定（textとして受け取られるのを回避）--}}
<div x-data="followHandler({{ $user->id }}, {{ json_encode($isFollowing) }})">
    <button
        @click="toggleFollow"
        class="text-sm px-4 py-1 rounded shadow transition
            focus:outline-none
            text-white"
        :class="following
            ? 'bg-rose-600 hover:bg-rose-700'
            : 'bg-amber-600 hover:bg-amber-700'"
    >
        <span x-text="following ? 'Unfollow' : 'Follow'"></span>
    </button>
</div>

<script>
    function followHandler(userId, initiallyFollowing) {
        return {
            following: initiallyFollowing,

            toggleFollow() {
                const method = this.following ? 'DELETE' : 'POST';
                const url = `/follow/${userId}`;

                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({}) // DELETE時の必須処理！
                }).then(response => {
                    if (response.ok) {
                        this.following = !this.following;
                    } else {
                        console.error('通信は成功');
                    }
                }).catch(err => {
                    console.error('通信エラー');
                });
            }
        }
    }
</script>
