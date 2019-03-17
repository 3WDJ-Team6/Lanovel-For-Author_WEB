<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->increments('num')->comment("작품번호");
            $table->string('work_title')->comment("작품명");
            $table->text('introduction_of_work')->nullable()->comment("작품소개");
            $table->integer('type_of_work')->comment("연재종류");
            $table->integer('status_of_work')->default(0)->comment("연재상태");
            $table->integer('hits_of_work')->comment("조회수");
            $table->integer('rental_price')->nullable()->comment("대여가격");
            $table->integer('buy_price')->comment("구매가격");
            $table->string('bookcover_of_work')->comment("작품표지");
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
        Schema::dropIfExists('works');
    }
}
