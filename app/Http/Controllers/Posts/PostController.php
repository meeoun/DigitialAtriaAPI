<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostAssets;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Contracts\IPost;
use App\Repositories\Eloquent\Criteria\EagerLoad;
use App\Repositories\Eloquent\Criteria\Query;
use Illuminate\Http\Request;


class PostController extends Controller
{
    protected $posts;

    public function __construct(IPost $posts)
    {
        $this->posts = $posts;
    }



    public function index(Request $request)
    {

        $posts = null;
        if($request->has('limit'))
        {
            $posts = $this->posts->withCriteria(new Query($request->query),
                new EagerLoad(['comments', 'media', 'user']))->all();

        }else{

            $posts = $this->posts->withCriteria(new Query($request->query),
                new EagerLoad(['comments', 'media', 'user']))
                ->paginate(10,$request->query->all());
        }

        if($request->has('assets'))
        {
            return PostAssets::collection($posts);
        }
        return PostResource::collection($posts);
    }




    public function show(Post $post)
    {
        return PostResource::collection($post);
    }

}
