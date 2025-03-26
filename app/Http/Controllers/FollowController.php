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
        Auth::user()->followings()->syncWithoutDetaching([$user->id]);

        return response()->json(['follow' => true]);
    }

    //アンフォロー処理
    public function unfollow($user_id)
    {
        $user = User::findOrFail($user_id);
        Auth::user()->followings()->detach($user->id);

        // return back();
        return response()->json(['follow' => false]);
    }

}
