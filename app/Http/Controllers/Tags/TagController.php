<?php

namespace App\Http\Controllers\Tags;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostAssets;
use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Repositories\Contracts\IPost;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class TagController extends Controller
{

    protected $posts;

    public function __construct(IPost $posts)
    {
        $this->posts = $posts;
    }


    public function posts($slug)
    {
        $posts = $this->posts->tagged($slug);
        return PostAssets::collection($posts);
    }

}
