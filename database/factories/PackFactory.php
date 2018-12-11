<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Pack::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'price' => $faker->randomDigitNotNull,
        'coins_price' => $faker->randomDigitNotNull * 100,
    ];
});
