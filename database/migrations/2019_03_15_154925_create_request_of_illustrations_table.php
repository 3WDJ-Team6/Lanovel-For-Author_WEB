<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestOfIllustrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_of_illustrations', function (Blueprint $table) {
            $table->increments('num')->comment("신청번호");

            $table->integer('request_id')->comment("신청자회원번호")->unsigned();
            $table->foreign('request_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('response_id')->comment("일러레회원번호")->unsigned();
            $table->foreign('response_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('type_of_request')->comment("신청타입");
            $table->integer('response_of_request')->default(1)->comment("요청결과");
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
        Schema::dropIfExists('request_of_illustrations');
    }
}
