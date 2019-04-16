<?php

use Illuminate\Database\Seeder;

class ContentOfWorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\CategoryWork::class, 300)->create();
    }
}
