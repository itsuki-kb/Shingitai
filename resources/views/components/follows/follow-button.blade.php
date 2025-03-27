@props(['user'])

@php
    $isFollowing = Auth::user()->followings->contains($user->id);
@endphp

{{-- json_encodeでbooleanのtrue/falseに指定（textとして受け取られるのを回避）--}}
<div x-data="followHandler({{ $user->id }}, {{ json_encode($isFollowing) }})" class="inline-flex">
    <button
    @click="toggleFollow"
    class="text-sm px-4 py-1 rounded border border-white text-green-700
        hover:text-opacity-50
        transition
        focus:outline-none focus:ring-0"
    >
        <span x-text="following ? 'Following!' : 'Follow?'"></span>
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
