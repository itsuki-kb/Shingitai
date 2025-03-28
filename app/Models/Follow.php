<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = ['followee_id', 'follower_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
