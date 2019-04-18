<?php

use Illuminate\Database\Seeder;

class PeriodOfWorkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PeriodOfWork::class, 15)->create();
    }
}
