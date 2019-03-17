<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('num')->comment("리뷰번호");

            $table->integer('num_of_work')->comment("작품번호")->unsigned();
            $table->foreign('num_of_work')
                  ->references('num')->on('works')
                  ->onDelete('cascade');

            $table->integer('user_id')->comment("리뷰작성자회원번호")->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->text('content_of_review')->comment("리뷰내용");
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
        Schema::dropIfExists('reviews');
    }
}
