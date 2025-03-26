<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($user_id, Request $request)
    {
        $user = $this->user->findOrFail($user_id);
        $tab = $request->query('tab', 'posts'); // tabのデフォルトをpostsに指定している

        $all_listing_data = match ($tab) {
            //Post情報を保持
            'likes' => Post::whereIn('id', $user->likes()->pluck('post_id'))->with('elements')->withCount('likes')->latest('date')->get(),
            default => $user->posts()->with('elements')->withCount('likes')->latest('date')->get(),
            //User情報を保持
            'followings' => $user->followings()->get(),
            'followers' => $user->followers()->get(),
        };

        //ログインユーザーがLikeしてあるポスト一覧のpost_idだけをArray形式で取得
        $liked_post_ids = Like::where('user_id', Auth::user()->id)
            ->pluck('post_id')
            ->toArray();

        return view('profile.show', compact('user', 'all_listing_data', 'tab', 'liked_post_ids'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // メールアドレスの変更があれば、verified_atがリセットされる
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        //Avatar画像の保存
        if ($request->hasFile('avatar')) {
            // 古い画像がある場合、削除
            if ($request->user()->avatar) {
                Storage::disk('public')->delete($request->user()->avatar);
            }

            // 新しい画像を保存
            // storage/app/public/avatarsに保存される
            // 'public' → ファイルシステムのディスク名（config/filesystems.php の 'disks.public'）を指定
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $avatarPath;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
