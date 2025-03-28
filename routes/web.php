<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;

//ログインしていない場合は、サイト紹介ページへ
Route::get('/', function () {
    return view('welcome');
});

//以下の機能はすべてログインしているユーザーに限定する
Route::middleware('auth')->group(function () {
    //Dadshboard
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/likes/{user_id}', [ProfileController::class, 'showLikes'])->name('profile.likes');
    Route::get('/profile/{user_id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Post
    Route::resource('post', PostController::class);

    //Like
    Route::post('/like/{post_id}', [LikeController::class, 'addLike'])->name('like.add');
    Route::delete('/like/{post_id}', [LikeController::class, 'deleteLike'])->name('like.delete');

    //Comment
    Route::post('/comment/{post_id}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{post_id}', [CommentController::class, 'delete'])->name('comment.delete');

    //follow
    Route::post('/follow/{user_id}', [FollowController::class, 'follow'])->name('follow');
    Route::delete('/follow/{user_id}', [FollowController::class, 'unfollow'])->name('unfollow');

});

require __DIR__.'/auth.php';



