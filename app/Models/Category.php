<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        /* category has many comments through the post */
        return $this->hasManyThrough(Comment::class, Post::class);
    }
}
