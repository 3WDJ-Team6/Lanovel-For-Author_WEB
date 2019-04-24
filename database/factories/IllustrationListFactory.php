<?php

use Faker\Generator as Faker;

$factory->define(App\Models\IllustrationList::class, function (Faker $faker) {
    return [
        'user_id' => App\Models\User::all()->random()->id,
        'illustration_title' => $faker->word,
        'price_of_illustration' => $faker->numberBetween(100, 10000),
        'hits_of_illustration' => $faker->numberBetween(0, 1000),
        'is_series' => rand(0, 1),
        'num_of_series' => 1,
        'position_of_illustration' => 'public/image/cubby.jpg',
        'introduction_of_illustration' => $faker->text,
    ];
});
