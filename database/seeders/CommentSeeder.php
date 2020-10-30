<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Comment::truncate();
        Comment::factory(200)->create();
        Comment::factory(200)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
