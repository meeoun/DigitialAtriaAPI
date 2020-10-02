<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $files = Media::where('disk','local')->get();
        foreach ($files as $file)
        {
            $model = app()->make($file->model_type)::findOrFail($file->model_id);
            $file->move($model, $file->collection_name, 's3');
        }
    }
}
