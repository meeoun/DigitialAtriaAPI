<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->removeFiles();
        $this->getImage();
        $this->imageAuthors();
        $this->imagePosts(Post::all());
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
        //Author image
        foreach(Author::withoutGlobalScope("author")->get() as $user)
        {
            $user->addMedia($this->imagePath)->preservingOriginal()->toMediaCollection('bio');
        }
        //user who is not author bio image
        foreach (User::all() as $user)
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
}
