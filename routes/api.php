<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Uploads\UploadController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Users\AuthorController;
use App\Http\Controllers\Comments\CommentController;
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


Route::get('posts', [PostController::class, 'index']);
Route::get('authors',[AuthorController::class, 'index']);


Route::get('author/{author:id}/posts',[AuthorController::class, 'posts']);

/*Comments*/
Route::get('comments',[CommentController::class, 'index']);
Route::post('comments/{post:id}/{comment:id}', [CommentController::class, 'storeReply']);


Route::delete('media/{media:id}',[UploadController::class, 'destroyFile']);

