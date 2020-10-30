<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreReplyRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Contracts\IComment;
use App\Repositories\Eloquent\Criteria\Query;
use Illuminate\Http\Request;

class CommentController extends APIController
{

    protected $comments;

    public function __construct(IComment $comments)
    {
        $this->comments = $comments;
    }

    public function index(Request $request)
    {
        $authors = null;
        if($request->has('limit'))
        {
            $comments = $this->comments->withCriteria(new Query($request->query))->all();

        }else{

            $comments = $this->comments->withCriteria(new Query($request->query))
                ->paginate(10);
        }
        return CommentResource::collection($comments);
    }



    public function storeReply(StoreReplyRequest $request,Post $post,Comment $comment)
    {
        $reply = new Comment($request->all());
        $reply->user_id = 1;
        $reply->reply_to = $comment->id;
        $reply->reason = "New Comment";
        $post->comments()->save($reply);

        return $this->JSON("Success", $reply);

    }




}
