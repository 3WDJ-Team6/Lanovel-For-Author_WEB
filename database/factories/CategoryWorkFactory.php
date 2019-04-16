<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CategoryWork::class, function (Faker $faker) {
    $num_of_work_min = App\Models\Work::min('num');
    $num_of_work_max = App\Models\Work::max('num');
    $tag = ['romance', 'advanture', 'fantasy', 'SF', 'action', 'thriller', 'mystery'];
    $num = $faker->numberBetween(0, 6);

    return [
        'num_of_work' => $faker->numberBetween($num_of_work_min, $num_of_work_max),
        'tag' => $tag[$num]
    ];
});
