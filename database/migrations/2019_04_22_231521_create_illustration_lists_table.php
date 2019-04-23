<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIllustrationListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illustration_lists', function (Blueprint $table) {
            $table->increments('num')->comment("일러스트번호");

            $table->integer('user_id')->comment("회원번호")->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->string('illustration_title')->comment("일러스트제목");
            $table->string('thumbnail')->nullable()->comment("썸네일");
            $table->integer('price_of_illustration')->comment("일러스트가격");
            $table->integer('hits_of_illustration')->comment("조회수");
            $table->text('introduction_of_illustration')->comment("일러스트소개");
            $table->integer('division_of_illustration')->comment("대구분");

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
        Schema::dropIfExists('illustration_lists');
    }
}
