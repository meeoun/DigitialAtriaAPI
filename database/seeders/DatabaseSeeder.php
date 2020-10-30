<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Factories\CommentFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DatabaseSeeder extends Seeder
{
    protected $imagePath;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->removeFiles();
        $this->dropTables();
        $this->getImage();
        $users = User::factory(20)->create();
        $this->imageAuthors();
        $posts = Post::factory(100)->create();
        $comments = Comment::factory(200)->create();
        $this->imagePosts($posts);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


    public function getImage()
    {
        $base = public_path().'/images/';
        $array = [];
        $files = File::files($base);
        foreach ($files as $file)
        {
            array_push($array,$file->getPath().'/'.$file->getFilename());
        }
       $this->imagePath = $array[0];
    }


    public function imageAuthors()
    {
        foreach(Author::withoutGlobalScope("author")->get() as $user)
        {
            $user->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('bio');
        }
    }



    public function imagePosts($posts)
    {
        foreach ($posts as $post)
        {
            //Main Image
            $post->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('main');

            //Banner Image

            $post->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('banner');

            //Post Carousel
            for($i=0; $i< rand(1,6); $i++)
            {
                $post->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('carousel');
            }

            //Gallery
            for($i=0; $i< rand(1,6); $i++)
            {
                $post->addMedia($this->imagePath)->preservingOriginal()->withCustomProperties(['caption' => 'This is a Caption!'])->toMediaCollection('gallery');
            }
        }

    }

    public function removeFiles()
    {
       $media = Media::all();
       foreach ($media as $file)
       {
           $file->delete();
       }
    }

    public function dropTables(){
        Post::truncate();
        User::truncate();
        Comment::truncate();
    }
}
