<?php

namespace App\Models\Traits;


trait Imageable
{

    public function getImageUrls(string $collection)
    {
        $urls= array();

        if($collection === "main" || $collection === "banner")
        {
            foreach ($this->getMedia($collection) as $image)
            {
                foreach ($image->custom_properties['generated_conversions'] as $key=>$value)
                {
                    $urls[$key]=["id"=>$image->id, "size"=>$key,"name"=>$image->file_name,"url"=>$image->getUrl($key), "caption"=>$image->getCustomProperty("caption")];
                }
            }
        }else{

            foreach ($this->getMedia($collection) as $image)
            {
                foreach ($image->custom_properties['generated_conversions'] as $key=>$value)
                {
                    array_push($urls,["id"=>$image->id, "size"=>$key,"name"=>$image->file_name,"url"=>$image->getUrl($key), "caption"=>$image->getCustomProperty("caption")]);
                }
            }
        }

        return $urls;
    }


    public function firstCollectionURL(string $collection)
    {
        foreach ($this->getMedia($collection) as $image)
        {
            foreach ($image->custom_properties['generated_conversions'] as $key=>$value)
            {
               return $image->getUrl($key);
            }
        }
    }

}
