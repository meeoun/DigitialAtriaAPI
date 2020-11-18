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
        $paginate = 10;
        if($request->has('paginate')){
            $paginate = $request->get('paginate');
        }

        $posts = null;
        if($request->has('limit'))
        {
            $posts = $this->posts->withCriteria(new Query($request->query),
                new EagerLoad(['comments', 'media', 'user']))->all();

        }else{

            $posts = $this->posts->withCriteria(new Query($request->query),
                new EagerLoad(['comments', 'media', 'user']))
                ->paginate($paginate,$request->query->all());
        }

        if($request->has('assets'))
        {
            return PostAssets::collection($posts);
        }
        return PostResource::collection($posts);
    }




    public function show(Post $post)
    {

        return new PostResource($post);
    }

    public function search(Request $request)
    {
        $filter = $request->get('search');

        $posts = $this->posts
            ->search($filter)
            ->paginate(Post::$paginate)->appends(["search"=>$filter]);

        return PostResource::collection($posts);

    }

}
