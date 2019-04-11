<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllCountView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW all_count_view AS 
        SELECT works.num, works.work_title, works.buy_price, works.rental_price, rental_count_view.ren , buy_count_view.buy
        FROM works 
        LEFT JOIN buy_count_view ON works.num = buy_count_view.num_of_work
        LEFT JOIN rental_count_view ON works.num = rental_count_view.num_of_work
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
