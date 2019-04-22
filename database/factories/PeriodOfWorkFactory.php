<?php

use Faker\Generator as Faker;

$factory->define(
    App\Models\PeriodOfWork::class,
    function (Faker $faker) {
        return [
            'num_of_work' => App\Models\Work::all()->num,
            'cycle_of_publish' => $faker->dayOfMonth() | $faker->dayOfWeek()
        ];
    }
);
