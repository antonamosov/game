<?php

use Faker\Generator as Faker;
use \App\Models\Question;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => $faker->text . '?'
    ];
});

$factory->state(Question::class, 'language_category', [
    'category_id' => 1
]);

$factory->state(Question::class, 'science_category', [
    'category_id' => 2
]);

$factory->state(Question::class, 'drama_category', [
    'category_id' => 3
]);

$factory->state(Question::class, 'art_and_design_category', [
    'category_id' => 4
]);

$factory->state(Question::class, 'select_type', [
    'type' => Question::TYPE_SELECT
]);

$factory->state(Question::class, 'text_type', [
    'type' => Question::TYPE_TEXT
]);