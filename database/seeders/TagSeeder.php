<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $posts = Post::all();
        $faker = \Faker\Factory::create();
       foreach ($posts as $post)
       {

           if($post->tags->count() < 1)
           {
               for ($i=0; $i < rand(1,10);$i++)
               {
                   $post->attachTag($faker->word);
               }
           }




       }


    }
}
