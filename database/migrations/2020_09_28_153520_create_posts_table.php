<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->text('summary')->nullable();
            $table->text('gallery_caption')->nullable();
            $table->decimal('average_score',8,1,true)->nullable();
            $table->string('score_description')->nullable();
            $table->longText('content');
            $table->unsignedBigInteger('user_id');
            $table->json('review_scores')->nullable();
            $table->integer('max_review_score')->default(10)->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->text('review_call_out')->nullable();
            $table->enum('type',['reviews','tutorials','news'])->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
