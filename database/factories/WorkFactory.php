<?php

use Faker\Generator as Faker;

$factory->define(App\Work::class, function (Faker $faker) {
    return [
        'work_title' => $faker->word,
        'introduction_of_work' => '잘부탁합니다.',
        'type_of_work' => rand(1, 3),
        'status_of_work' => rand(0, 1),
        'rental_price' => numberBetween(100, 50000),
        'buy_price' => numberBetween(500, 50000),
        'bookcover_of_work' => 'public/image/cubby.jpg'
    ];
});
