<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

//ログインしていない場合は、サイト紹介ページへ
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//以下の機能はすべてログインしているユーザーに限定する
Route::middleware('auth')->group(function () {
    //トップページ（タイムライン）
    //Route::get('/index', [PostController::class, 'index']);

    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{user_id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Post
    Route::resource('post', PostController::class);

    //Like
    Route::post('/like/{post_id}', [LikeController::class, 'addLike'])->name('like.add');
    Route::delete('/like/{post_id}', [LikeController::class, 'deleteLike'])->name('like.delete');

});

require __DIR__.'/auth.php';



