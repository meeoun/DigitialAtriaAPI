<?php

namespace App\Models\Traits;
use App\Models\Comment;

trait Commentable
{

    public static function bootLikeable()
    {
        static::deleting(function($model)
        {
            $model->removeComments();
        });
    }

    public function removeComments()
    {
        if($this->comments()->count()){
            $this->comments()->delete();
        }
    }


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
