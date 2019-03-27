<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    #생성 : php artisan make:seeder UsersTableSeeder
    public function run()
    {
        factory(App\Models\User::class, 10)->create();
    }
}
