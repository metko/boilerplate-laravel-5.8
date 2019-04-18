<?php

use Illuminate\Database\Seeder;

class PostsCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 5; $i <= 8; $i++ ){
            factory(App\Comment::class)->create([
                'owner_id' => $i,
                'post_id' => 1
            ]);
        }
        for($i = 5; $i <= 8; $i++ ){
            factory(App\Comment::class)->create([
                'owner_id' => $i,
                'post_id' => 2
            ]);
        }
        for($i = 5; $i <= 8; $i++ ){
            factory(App\Comment::class)->create([
                'owner_id' => $i,
                'post_id' => 3
            ]);
        }

        for($i = 1; $i <= 3; $i++ ){
            factory(App\Comment::class)->create([
                'owner_id' => 2,
                'post_id' => $i
            ]);
        }
        for($i = 1; $i <= 3; $i++ ){
            factory(App\Comment::class)->create([
                'owner_id' => 3,
                'post_id' => $i
            ]);
        }
        for($i = 1; $i <= 3; $i++ ){
            factory(App\Comment::class)->create([
                'owner_id' => 4,
                'post_id' => $i
            ]);
        }
    }
}
