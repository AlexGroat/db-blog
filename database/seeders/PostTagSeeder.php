<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // no model t run a factory, create a function to seed post tags
        for ($i = 1; $i <= 20; $i++) {
            DB::table('post_tag')->insert([
                // assign a post tag to a random post from 1 to the count of the number of posts
                'post_id' => mt_rand(1, Post::all()->count()),
                // create tags up to amount created in the Tag Factory
                'tag_id' => mt_rand(1, 10)
            ]);
        }
    }
}
