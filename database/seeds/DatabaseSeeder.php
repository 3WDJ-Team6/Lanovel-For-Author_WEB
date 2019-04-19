<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    # 호출 : php artisan db:seed
    # refresh 후에 seeding하기 : php arisan migrate:refresh --seed
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(WorkTableSeeder::class);
        $this->call(WorkListTableSeeder::class);
        $this->call(PeriodOfWorkTableSeeder::class);
        $this->call(ChapterOfWorkTableSeeder::class);
        $this->call(ContentOfWorkTableSeeder::class);
        $this->call(RentalTableSeeder::class);
    }
}
