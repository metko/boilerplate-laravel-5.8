<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'description' => $faker->paragraph,
        'model' => 'App\Model'
    ]; 
});
