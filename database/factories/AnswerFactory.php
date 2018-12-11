<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Answer::class, function (Faker $faker) {
    return [
        'title' => $faker->word
    ];
});

$factory->state(\App\Models\Answer::class, 'right', function () {
    return [
        'right' => true,
        'title' => 'right_answer'
    ];
});

$factory->state(\App\Models\Answer::class, 'not_right', function () {
    return [
        'right' => false
    ];
});
