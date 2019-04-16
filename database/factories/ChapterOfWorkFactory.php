<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ChapterOfWork::class, function (Faker $faker) {
    $num_of_work_min = App\Models\Work::min('num');
    $num_of_work_max = App\Models\Work::max('num');

    return [
        'num_of_work' => $faker->numberBetween($num_of_work_min, $num_of_work_max),
        'subtitle' => $faker->name,
        'check_of_working' => rand(0, 1)
    ];
});
