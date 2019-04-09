<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RentalCountView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW rental_count_view
            AS 
            SELECT 
                num_of_work , COUNT(*) AS ren
            FROM 
                rentals 
            WHERE due_of_rental IS NOT null
            GROUP BY num_of_work;
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
