<?php

namespace App\Http\Resources\Authors;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorPostAsset extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'views'=> $this->views,
            'comments' => $this->comments->count(),
            'average_score'=> $this->when($this->type === 'reviews',$this->average_score) ,
            'score_description'=> $this->when($this->type === 'reviews',$this->score_description),
            'images'=>[
                'main' => $this->getImageUrls("main"),
                'banner'=>$this->getImageUrls("banner"),
            ],
            'dates' =>[
                'created' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at,
                'published' => $this->published_at ? $this->published_at->diffForHumans() : null,
                'published_at' => $this->published_at
            ]
        ];
    }
}
