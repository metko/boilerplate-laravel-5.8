<?php

use App\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'filename' => 'media name',
        'path' => 'test',
        'size' => 'original',
        
    ];
});
