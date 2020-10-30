<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = User::all();
       foreach ($users as $user)
       {
           $user->slug = Str::slug($user->name);
           $user->save();
       }
    }
}
