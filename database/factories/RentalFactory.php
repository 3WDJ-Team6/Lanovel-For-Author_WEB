<?php

use Faker\Generator as Faker;

$factory->define(
    App\Models\Rental::class,
    function (Faker $faker) {
        $num_of_work_min = App\Models\Work::min('num');
        $num_of_work_max = App\Models\Work::max('num');
        $num_of_chapter_min = App\Models\ChapterOfWork::min('num');
        $num_of_chapter_max = App\Models\ChapterOfWork::max('num');
        $user_id_min = App\Models\User::min('id');
        $user_id_max = App\Models\User::max('id');

        return [
            'user_id' => $faker->numberBetween($user_id_min, $user_id_max),
            'num_of_work' => $faker->numberBetween($num_of_work_min, $num_of_work_max),
            'due_of_rental' => $faker->null | 3,
            'chapter_of_work' => $faker->numberBetween($num_of_chapter_min, $num_of_chapter_max),
            'onlyDate' => $faker->date($format = 'y-m-d', $max = 'now')
        ];
    }
);
