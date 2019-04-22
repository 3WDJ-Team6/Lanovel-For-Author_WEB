<?php

use Faker\Generator as Faker;

$factory->define(App\Models\WorkList::class, function (Faker $faker) {

    return [
        'num_of_work' => App\Models\Work::all()->random()->num,
        'user_id' => App\Models\User::all()->random()->id,
        'accept_request' => rand(0, 1),
        'last_time_of_working' => 'test'
    ];
});
