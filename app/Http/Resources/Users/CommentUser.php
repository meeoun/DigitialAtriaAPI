<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentUser extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'image'=> $this->firstCollectionURL("bio"),
            'dates' =>[
                'joined' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ]
        ];
    }
}
