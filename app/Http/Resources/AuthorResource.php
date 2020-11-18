<?php

namespace App\Http\Resources;

use App\Http\Resources\Authors\AuthorPostAsset;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $more = $this->morePosts(4);
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'slug' => $this->slug,
            'bio' => $this->bio,
            'image'=> $this->firstCollectionURL("bio"),
            'posts'=>$this->posts->count(),
            'types'=> $this->types(),
            'dates' =>[
                'joined' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ],
            'recent_posts'=> AuthorPostAsset::collection($more)
        ];
    }
}
