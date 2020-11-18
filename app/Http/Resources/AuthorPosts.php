<?php

namespace App\Http\Resources;

use App\Http\Resources\Authors\AuthorPostAsset;
use App\Repositories\Contracts\IAuthor;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AuthorPosts extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $paginate = 4;
        $posts = $this->posts()->paginate($paginate)
            ->appends(["user_id"=>$this->id,"assets"=>"true", "paginate"=>$paginate])
            ->withPath(URL::to('/'). '/api/posts');
        $links = $posts->toArray()["links"];
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'slug' => $this->slug,
            'bio' => $this->bio,
            'image'=> $this->firstCollectionURL("bio"),
            'post_count'=>$this->posts->count(),
            'types'=> $this->types(),
            'post_data'=> ["posts"=>AuthorPostAsset::collection($posts), "links"=>$links],
            'dates' =>[
                'joined' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ]
        ];
    }
}
