<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Uploads\UploadController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Users\AuthorController;
use App\Http\Controllers\Comments\CommentController;
use App\Http\Controllers\Tags\TagController;
use App\Http\Controllers\Site\SiteController;
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

Route::get('search/posts',[PostController::class, 'search']);


Route::get('posts', [PostController::class, 'index']);
Route::get('authors',[AuthorController::class, 'index']);




Route::get('tags/{slug}', [TagController::class, 'posts']);




Route::get('author/{author:slug}/posts',[AuthorController::class, 'posts']);


Route::get('layout', [SiteController::class, 'layout']);
Route::get('contact', [SiteController::class, 'contact']);

Route::post('contact', [SiteController::class, 'storeContactMessage']);
Route::post('recaptcha', [SiteController::class, 'recaptcha']);




/*Comments*/
Route::get('comments',[CommentController::class, 'index']);
Route::post('comments/{post:id}/{comment:id}', [CommentController::class, 'storeReply']);


Route::delete('media/{media:id}',[UploadController::class, 'destroyFile']);

