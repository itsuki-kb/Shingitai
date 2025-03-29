<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    // フォロー処理
    public function follow($user_id)
    {
        $user = User::findOrFail($user_id);

        //follower_idにAuth:user->id, followee_idに$user->idを追加
        //syncWithoutDetaching = 更新はせず、追加だけするメソッド
        Auth::user()->followings()->syncWithoutDetaching([$user->id]);

        return response()->json(['follow' => true]);
    }

    //アンフォロー処理
    public function unfollow($user_id)
    {
        $user = User::findOrFail($user_id);

        //follower_idがAuth:user->idで、followee_idが$user_idのデータを削除
        Auth::user()->followings()->detach($user->id);

        return response()->json(['follow' => false]);
    }

}
