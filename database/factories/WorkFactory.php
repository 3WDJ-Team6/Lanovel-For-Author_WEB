<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Work::class, function (Faker $faker) {
    return [
        'work_title' => $faker->word,
        'introduction_of_work' => $faker->text,
        'type_of_work' => rand(1, 3),
        'status_of_work' => rand(0, 1),
        'hit_of_work' => $faker->numberBetween(0, 1000),
        'rental_price' => $faker->numberBetween(100, 10000),
        'buy_price' => $faker->numberBetween(100, 30000),
        'bookcover_of_work' => 'public/image/cubby.jpg'
    ];
});
