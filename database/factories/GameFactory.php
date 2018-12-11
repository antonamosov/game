<?php

use Faker\Generator as Faker;
use \App\Models\Game;

$factory->define(Game::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'user_turn_id' => 1,
        'opponent_id' => 1,
        'type' => Game::TYPE_GAME
    ];
});

$factory->state(Game::class, 'waiting', function (Faker $faker) {
    return [
        'status' => Game::STATUS_WAITING
    ];
});

$factory->state(Game::class, 'test_game', function (Faker $faker) {
    return [
        'user_id' => 2,
        'opponent_id' => 1,
        'status' => Game::STATUS_WAITING
    ];
});
