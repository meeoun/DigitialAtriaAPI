<?php

namespace App\Models\Traits;


use App\Models\Post;

trait Authorable
{

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

}
