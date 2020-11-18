<?php

namespace App\Models;

use App\Models\Traits\Authorable;
use App\Models\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Author extends Model implements HasMedia
{
    use HasFactory, Imageable, InteractsWithMedia;

    protected $table = "users";
    protected $hidden = ["active_author","admin","can_approve","can_self_approve","email_verified_at","password","remember_token"];
    public static $paginate = 6;

    protected static function booted()
    {
        static::addGlobalScope('author', function (Builder $builder) {
            $builder->where('active_author','=',true);
        });
    }

    public function registerMediaConversions(Media $media = null): void
    {
        /*Main Image Conversions */
        $conversions = array('100_100');
        foreach ($conversions as $conversion) {
            $array = explode("_", $conversion);
            $width = (int)$array[0];
            $height = (int)$array[1];
            $this->addMediaConversion("dimension_$conversion")
                ->fit("crop", $width, $height)
                ->performOnCollections('bio');
        }
    }


    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function types()
    {
        return $this->posts()->pluck('type')->unique();
    }

    public function morePosts($limit)
    {
        return $this->posts()->orderBy('published_at', 'desc')->limit($limit)->get();
    }


}
