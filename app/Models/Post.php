<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTags;
    use Searchable;
    use SoftDeletes;
    use Commentable;


    protected $dates = [
      'published_at'
    ];

    protected $fillable =['title'];





    public function getImageUrls(string $collection)
    {
        $urls= array();
        foreach ($this->getMedia($collection) as $image)
        {
            foreach ($image->custom_properties['generated_conversions'] as $key=>$value)
            {
                array_push($urls,["id"=>$image->id, "size"=>$key,"name"=>$image->file_name,"url"=>$image->getUrl($key)]);
            }
        }
        return $urls;
    }



    public function getAverageScoreAttribute()
    {
        $score = 0;
        $count = 0;
        foreach(json_decode($this->review_scores) as $review_score)
        {
            $score += $review_score->score;
            $count++;
        }
        return ($score/$count);
    }

    public function getScoreDescriptionAttribute()
    {

        switch ((int)$this->average_score)
        {
            case 0:
                return "What?";
            case 1:
                return "Broken";
            case 2:
                return "Unplayable";
            case 3:
                return "Terrible";
            case 4:
                return "Bad";
            case 5:
                return "Average";
            case 6:
                return "OK";
            Case 7:
                return "Good";
            case 8:
                return "Great!";
            case 9:
                return "Awesome!";
            case 10:
                return "Perfect";
        }
    }







    public function registerMediaConversions(Media $media = null): void
    {
        /*Main Image Conversions */
        $conversions = array('400_430', '270_200','100_80','80_70','185_80','270_150','85_70','89_79','250_200');
        foreach ($conversions as $conversion)
        {
            $array = explode("_",$conversion);
            $width = (int)$array[0];
            $height = (int)$array[1];
            $this->addMediaConversion($conversion)
                ->fit("crop", $width, $height)
                ->performOnCollections('main');
        }

        /* Carousel Image Conversions */
        $conversions = array('770_380');
        foreach ($conversions as $conversion)
        {
            $array = explode("_",$conversion);
            $width = (int)$array[0];
            $height = (int)$array[1];
            $this->addMediaConversion($conversion)
                ->fit("crop", $width, $height)
                ->performOnCollections('carousel');
        }


        /* Gallery Image Conversions */
        $conversions = array('185_160');
        foreach ($conversions as $conversion)
        {
            $array = explode("_",$conversion);
            $width = (int)$array[0];
            $height = (int)$array[1];
            $this->addMediaConversion($conversion)
                ->fit("crop", $width, $height)
                ->performOnCollections('gallery');
        }


    }
}
