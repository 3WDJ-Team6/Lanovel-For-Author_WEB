<?php

use Faker\Generator as Faker;
use Faker\Provider\ko_KR\PhoneNumber;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
    App\Models\User::class,
    function (Faker $faker) {
        return [
            // 'id' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 123,
            'point' => $faker->numberBetween(0, 100000),
            'roles' => rand(1, 3),
            'adult_certification' => rand(0, 1),
            'phone_number' => $faker->phoneNumber,
            'nickname' => $faker->firstName($gender = 'male' | 'female'),
            'remember_token' => str_random(10),
        ];
    }
);
