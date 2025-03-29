<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function addLike($post_id)
    {
        $this->like->firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $post_id,
        ]);

        return response()->json(['liked' => true]);
    }

    public function deleteLike($post_id)
    {
        $like = $this->like
            ->where('post_id', $post_id)
            ->where('user_id', Auth::id())
            ->first();

        $like->delete();

        return response()->json(['liked' => false]);
    }


}
