<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = array("reviews","tutorials", "news");
        $type = $type[array_rand($type)];
        $scores =null;
        $max = null;
        $deleted = null;
        $published = null;
        if($type === "reviews")
        {
            $scores = \ReviewScore::scores(5);
            $max = 10;
        }
        if(rand(1,100) > 75)
        {
            $deleted = now();
        }

        if(rand(1,100) > 75)
        {
            $published = now();
        }

        $title = $this->faker->unique()->jobTitle;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->sentences(3,true),
            'summary' => $this->faker->sentences(8,true),
            'content' => $this->faker->sentences(40,true),
            'user_id' => User::inRandomOrder()->first()->id,
            'gallery_caption'=>"This is the main gallery caption!",
            'review_scores' => $scores,
            'max_review_score' => $max,
            'views' => rand(1,1000),
            'review_call_out' => $this->faker->sentences(2,true),
            'type' => $type,
            'published_at' => $published,
            'deleted_at' => $deleted,
        ];
    }
}
