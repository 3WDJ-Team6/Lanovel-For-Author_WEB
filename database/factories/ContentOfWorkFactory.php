<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ContentOfWork::class, function (Faker $faker) {
    $num_of_work_min = App\Models\Work::min('num');
    $num_of_work_max = App\Models\Work::max('num');
    $num_of_chapter_min = App\Models\ChapterOfWork::min('num');
    $num_of_chapter_max = App\Models\ChapterOfWork::max('num');

    return [
        'num_of_work' => $faker->numberBetween($num_of_work_min, $num_of_work_max),
        'num_of_chapter' => $faker->numberBetween($num_of_chapter_min, $num_of_chapter_max),
        'subsubtitle' => $faker->name,
        'content' => $faker->text
    ];
});
