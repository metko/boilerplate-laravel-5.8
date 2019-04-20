<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'location' => $faker->state,
        'bio' => $faker->paragraph
    ];
});
