<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpiredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expireds', function (Blueprint $table) {
            $table->integer('rental_num')->comment("구매및대여번호")->unsigned();

            $table->foreign('rental_num')
                ->references('num')->on('rentals');

            $table->date('expired_date')->comment("만료날짜")->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expireds');
    }
}
