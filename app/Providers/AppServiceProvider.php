<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ログインユーザーが所有者かどうかチェックする（例：$postを渡すとpost_idが参照される）
        // $userは自動的にAuth::user()を指す
        Gate::define('isOwner', function ($user, $model) {
            return $user->id === $model->user_id;
        });
    }
}
