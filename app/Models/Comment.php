<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id'];


    public function commentable()
    {

        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class,'reply_to');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
