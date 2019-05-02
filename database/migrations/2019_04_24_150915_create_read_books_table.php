<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('read_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_of_work')->comment("작품번호")->unsigned();
            $table->foreign('num_of_work')
                ->references('num')->on('works')
                ->onDelete('cascade');

            $table->string('url')->comment("대여 및 구매 시 URL");
            $table->string('downloadUrl')->comment("다운로드 URL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('read_books');
    }
}
