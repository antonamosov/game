<?php

use \App\Models\Round;

$factory->define(Round::class, function () {
    return [
        'game_id' => 12
    ];
});

$factory->state(Round::class, 'number_1', [
    'number' => 1,
]);

$factory->state(Round::class, 'number_2', [
    'number' => 2,
]);

$factory->state(Round::class, 'number_3', [
    'number' => 3,
]);