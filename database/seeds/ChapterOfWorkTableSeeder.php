<?php

use Illuminate\Database\Seeder;

class ChapterOfWorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\CategoryWork::class, 50)->create();
    }
}
