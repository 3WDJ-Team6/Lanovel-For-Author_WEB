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
            SELECT works.num , works.work_title,if(if(isnull(rentals.due_of_rental)  ,1,2)=1,works.buy_price,works.rental_price) AS price, 
            date_format(rentals.created_at,'%y-%m-%d')AS date,if(isnull(rentals.due_of_rental)  ,1,2) AS renOrBuy 
            FROM works
            LEFT JOIN rentals ON works.num = rentals.num_of_work
            WHERE rentals.created_at IS NOT NULL
            ORDER BY works.num ASC
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
