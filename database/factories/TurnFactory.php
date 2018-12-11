<?php

use \App\Models\Turn;

$factory->define(Turn::class, function () {
    return [
        'status' => Turn::STATUS_WRONG,
    ];
});

$factory->state(Turn::class, 'number_1', [
    'number' => 1
]);

$factory->state(Turn::class, 'number_2', [
    'number' => 2
]);

$factory->state(Turn::class, 'number_3', [
    'number' => 3
]);

$factory->state(Turn::class, 'user_1', [
    'user_id' => 1
]);

$factory->state(Turn::class, 'user_2', [
    'user_id' => 2
]);

$factory->state(Turn::class, 'empty', [
    'status' => Turn::STATUS_EMPTY
]);