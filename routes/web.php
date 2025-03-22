<?php

use Illuminate\Support\Facades\Route;
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
    Route::get('/index', [PostController::class, 'index']);

    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Post
    Route::resource('post', PostController::class);
});

require __DIR__.'/auth.php';



