<?php

use Illuminate\Database\Seeder;

class CategoryWorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\CategoryWork::class, 0)->create();
    }
}
