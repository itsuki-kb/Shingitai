<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostElement extends Model
{
    protected $fillable = ['post_id', 'category', 'content', 'condition', 'image'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
