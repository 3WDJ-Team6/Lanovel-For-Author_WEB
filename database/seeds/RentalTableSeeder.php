<?php

use Illuminate\Database\Seeder;

class RentalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Rental::class, 30)->create();
    }
}
