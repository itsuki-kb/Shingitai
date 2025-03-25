<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'date'];

    public function elements()
    {
        return $this->hasMany(PostElement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //Likeしてある投稿があるかをチェック
    public function isLikedBy($user_id)
    {
        return $this->likes()->where('user_id', $user_id)->exists();
    }
}
