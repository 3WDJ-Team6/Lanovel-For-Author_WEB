<?php

use Illuminate\Database\Seeder;

class WorkListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\WorkList::class, 70)->create();
    }
}
