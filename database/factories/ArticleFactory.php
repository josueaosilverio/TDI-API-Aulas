<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->realText($maxNbChars = 50, $indexSize = 2),
        'description' => $faker->realText($maxNbChars = 300, $indexSize = 2),
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'user_id' => $faker->numberBetween(1, 50)
    ];
});
