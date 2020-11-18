<?php
namespace App\Repositories\Eloquent;
use App\Models\Post;
use App\Repositories\Contracts\IPost;

class PostRepository extends BaseRepository implements IPost
{

    public function model()
    {
        return Post::class;
    }

    public function tagged($slug)
    {
        return $this->model->withAnyTags($slug)->get();
    }
    public function search($search)
    {
        return $this->model
            ->where('title','like',"%$search%")
            ->orWhere('content','like',"%$search%");
    }


}
