<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 3; $i <= 5; $i++ ){
           factory(Post::class)->create(['owner_id' => $i]);
        }   
        
        
    }
}
