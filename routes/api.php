<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Uploads\UploadController;
use App\Http\Controllers\Posts\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', function () {
    return response()->json(['message'=> 'hello'],200);
});



Route::post('posts/{post:id}',[UploadController::class, 'postAttachImage']);
Route::get('posts/{post:id}',[PostController::class, 'show']);



Route::delete('media/{media:id}',[UploadController::class, 'destroyFile']);

