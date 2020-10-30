<?php

namespace App\Models;

use App\Models\Traits\Authorable;
use App\Models\Traits\Imageable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable;
    use InteractsWithMedia;
    use Imageable;



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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }



}
