<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Repositories\Contracts\IPost;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends Controller
{
    protected $posts;

    public function __construct(IPost $posts)
    {
        $this->posts = $posts;
    }



    public function show(Post $post)
    {
        $posts = $this->posts->all();

        dd($posts);
        return new PostResource($post);
    }

}
