<?php

namespace App\Http\Resources;

use App\Http\Resources\Users\CommentUser;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $replies = $this->replies()->paginate(2)->appends(["reply_id"=>$this->id, "commentable_type"=>$this->getMorphClass()]);
        $links = $replies->toArray()["links"];

        return [
            'id' => $this->id,
            'user' => new CommentUser($this->user),
            'body' => $this->body,
            'reply_id'=>$this->reply_to,
            'reply_count'=>$this->replies->count(),
            $this->mergeWhen(!$this->reply_to, [
                'reply_data'=>["replies" => CommentResource::collection($replies),"links"=>$links],
            ]),
            'dates' =>[
                'created' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at
            ]
        ];
    }
}
