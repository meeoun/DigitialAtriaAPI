<?php

namespace App\Http\Controllers\Uploads;

use App\Http\Controllers\APIController;
use App\Http\Requests\Posts\PostAttachImage;
use App\Jobs\DestroyFile;
use App\Jobs\FileToS3;
use App\Models\Post;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadController extends APIController
{
    public function postAttachImage(PostAttachImage $request,Post $post)
    {
        $post->addMedia($request->image)
            ->toMediaCollection($request->placement);
        FileToS3::dispatch();
        return $this->JSON("Image Added");
    }

    public function destroyFile(Media $media)
    {
        DestroyFile::dispatch($media);
        return $this->JSON("File Destroyed");
    }



}
