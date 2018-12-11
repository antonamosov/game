<?php

use Faker\Generator as Faker;
use \App\Models\Notification;

$factory->define(Notification::class, function () {
    return [
        'user_id' => 1,
    ];
});

$factory->state(Notification::class, 'rejected',  function () {
    return [
        'user_id' => 1,
        'status' => Notification::STATUS_REJECTED
    ];
});

$factory->state(Notification::class, 'accepted',  function () {
    return [
        'user_id' => 1,
        'status' => Notification::STATUS_ACCEPTED
    ];
});

$factory->state(Notification::class, 'waiting',  function () {
    return [
        'user_id' => 1,
        'status' => Notification::STATUS_WAITING_OF_ACCEPT
    ];
});



