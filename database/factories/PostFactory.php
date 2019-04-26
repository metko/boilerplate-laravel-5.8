<?php

use App\User;
use App\PostStatus;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => "Fuck faker",
        'body' => $faker->paragraph,
        // 'status_id' => function() {
        //     return factory(PostStatus::class)->create()->id;
        // },
        'owner_id' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});
