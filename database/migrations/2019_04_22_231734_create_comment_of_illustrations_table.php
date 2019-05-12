<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentOfIllustrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_of_illustrations', function (Blueprint $table) {
            $table->increments('num')->comment("댓글번호");

            $table->integer('num_of_illustration')->comment("일러스트번호")->unsigned();
            $table->foreign('num_of_illustration')
                  ->references('num')->on('illustration_lists')
                  ->onDelete('cascade');
            
            $table->integer('user_id')->comment("댓글작성자회원번호")->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
                  
            $table->text('content_of_comment')->comment("댓글내용");

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
        Schema::dropIfExists('comment_of_illustrations');
    }
}
