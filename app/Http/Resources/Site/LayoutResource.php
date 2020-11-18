<?php

namespace App\Http\Resources\Site;

use App\Http\Resources\PostAssets;
use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Models\SiteSetting;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Tags\Tag;

class LayoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'navigation'=>[
                'reviews'=>PostAssets::collection(Post::published()->where('type','reviews')->latest()->take(5)->get()),
                'tutorials'=>PostAssets::collection(Post::published()->where('type','tutorials')->latest()->take(5)->get()),
                'news'=>PostAssets::collection(Post::published()->where('type','news')->latest()->take(5)->get())
            ],
            'top'=>[
              'recent'=>PostAssets::collection(Post::published()->latest()->take(6)->get())
            ],
            'side'=>[
                'popular'=> PostAssets::collection(Post::published()->orderBy('views', 'desc')->take(5)->get()),
                'recent'=>PostAssets::collection(Post::published()->latest()->take(5)->get()),
                'top'=> PostAssets::collection(Post::published()->withCount('comments')->orderBy('comments_count', 'desc')->take(5)->get()),
            ],
            'footer' => [
                'about'=> SiteSetting::where('title','About')->first(),
                'random_posts'=> PostAssets::collection(Post::published()->inRandomOrder()->take(2)->get()),
                'random_tags'=> TagResource::collection(Tag::inRandomOrder()->take(12)->get()),
                'images'=>Post::recentImages()
            ],
        ];
    }
}
