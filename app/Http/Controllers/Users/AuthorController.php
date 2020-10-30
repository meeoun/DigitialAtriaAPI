<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorPosts;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\PostResource;
use App\Models\Author;
use App\Repositories\Contracts\IAuthor;
use App\Repositories\Eloquent\Criteria\Query;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    protected $authors;

    public function __construct(IAuthor $authors)
    {
        $this->authors = $authors;
    }



    public function index(Request $request)
    {
        $authors = null;
        if($request->has('limit'))
        {
            $authors = $this->authors->withCriteria(new Query($request->query))->all();

        }else{

            $authors = $this->authors->withCriteria(new Query($request->query))
                ->paginate(2);
        }
        return AuthorResource::collection($authors);
    }


    public function posts(Author $author)
    {
       return new AuthorPosts($author);
    }


}
