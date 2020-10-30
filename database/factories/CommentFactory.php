<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $post = Post::whereNotNull('published_at')->inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $reply = null;
        if($this->faker->randomFloat(null,0,10) >4 )
        {
            $reply = Comment::inRandomOrder()->first();
        }
        if($reply && !$reply->approved)
        {
            $reply->approved = true;
            $reply->save();
        }

        return [
            'commentable_type' =>  $post->getMorphClass(),
            'commentable_id'=>$post->id,
            'user_id'=>$user->id,
            'reply_to'=>$reply ? $reply->id : $reply,
            'body'=>$this->faker->sentence(20,true),
            'approved'=>$this->faker->randomElement([true,false]),
            'reason'=>$this->faker->sentence(3,true),
        ];
    }
}
