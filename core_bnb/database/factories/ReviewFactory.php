<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'id' => Str::uuid(),
        'content' => $faker->sentences(5, true),    //  Generate 5 sentences
        'rating' => random_int(1, 5)                //  Generate random value from 1 to 5
    ];
});
