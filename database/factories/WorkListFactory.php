<?php

use Faker\Generator as Faker;

$factory->define(App\Models\WorkList::class, function (Faker $faker) {
    $num_of_work_min = App\Models\Work::min('num');
    $num_of_work_max = App\Models\Work::max('num');
    $user_id_min = App\Models\User::min('id');
    $user_id_max = App\Models\User::max('id');

    return [
        'num_of_work' => $faker->numberBetween($num_of_work_min, $num_of_work_max),
        'user_id' => $faker->numberBetween($user_id_min, $user_id_max),
        'accept_request' => rand(0, 1),
        'last_time_of_working' => 'test'
    ];
});
