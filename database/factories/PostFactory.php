<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'body' => $faker->paragraph,
        'owner_id' => function() {
            return factory(User::class)->create()->id;
        }
    ];
});
