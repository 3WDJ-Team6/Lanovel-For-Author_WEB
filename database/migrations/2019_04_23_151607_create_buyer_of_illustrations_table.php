<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyerOfIllustrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyer_of_illustrations', function (Blueprint $table) {
            $table->integer('num_of_illustration')->comment("일러스트번호")->unsigned();
            $table->foreign('num_of_illustration')
                ->references('num')->on('illustration_lists');

            $table->integer('user_id')->comment("회원번호")->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyer_of_illustrations');
    }
}
