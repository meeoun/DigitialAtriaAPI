<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
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
        $users = User::factory(10)->create();
        $posts = Post::factory(5)->create();
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


    public function imagePosts($posts)
    {
        foreach ($posts as $post)
        {
            //Main Image
            $post->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('main');

            //Post Carousel
            for($i=0; $i< rand(1,6); $i++)
            {
                $post->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('carousel');
            }

            //Gallery
            for($i=0; $i< rand(1,6); $i++)
            {
                $post->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('gallery');
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
    }
}
