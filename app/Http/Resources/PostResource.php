<?php

namespace App\Http\Resources;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $comments = $this->comments()->paginate(2)->appends(["commentable_id"=>$this->id, "commentable_type"=>$this->getMorphClass()]);
        $links = $comments->toArray()["links"];
        return [
            'id' => $this->id,
            'author' => new AuthorResource($this->Author),
            'title' => $this->title,
            'type' => $this->type,
            'slug' => $this->slug,
            'views'=> $this->views,
            'comments' => $this->comments->count(),
            'excerpt' => $this->excerpt,
            'summary' => $this->summary,
            'gallery_caption' => $this->gallery_caption,
            'content' => $this->content,
            $this->mergeWhen($this->type === 'reviews',[
            'average_score'=>$this->average_score,
            'score_description'=> $this->score_description,
            'review_scores'=> json_decode($this->review_scores),
            'max_score' => $this->max_review_score,
            'review_call_out'=> $this->review_call_out
            ]),
            'images'=>[
                'main' => $this->getImageUrls("main"),
                'banner'=>$this->getImageUrls("banner"),
                'carousel'=>$this->getImageUrls("carousel"),
              'gallery'=> $this->getImageUrls("gallery")
            ],
            'dates' =>[
                'created' => $this->created_at->diffForHumans(),
                'created_at' => $this->created_at,
                'published' => $this->published_at ? $this->published_at->diffForHumans() : null,
                'published_at' => $this->published_at
            ],
            'comment_data'=> ["comments"=>CommentResource::collection($comments),"links"=> $links]
        ];
    }
}
