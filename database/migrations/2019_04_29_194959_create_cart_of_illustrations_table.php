<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartOfIllustrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_of_illustrations', function (Blueprint $table) {
            $table->increments('id')->comment("주문번호");

            $table->integer('num_of_illust')->comment("일러스트번호")->unsigned();
            $table->foreign('num_of_illust')
                ->references('num')->on('illustration_lists')
                ->onDelete('cascade');

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
        Schema::dropIfExists('cart_of_illustrations');
    }
}
