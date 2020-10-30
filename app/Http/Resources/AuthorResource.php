<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'bio' => $this->bio,
            'image'=> $this->firstCollectionURL("bio"),
            'posts'=>$this->posts->count(),
            'types'=> $this->types(),
            'dates' =>[
                'joined' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ]
        ];
    }
}
