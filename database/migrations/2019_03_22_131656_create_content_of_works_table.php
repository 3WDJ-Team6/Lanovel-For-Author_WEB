<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentOfWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_of_works', function (Blueprint $table) {
            $table->increments('num')->comment("회차번호");
            
            $table->integer('num_of_chapter')->comment("챕터번호")->unsigned();
            $table->foreign('num_of_chapter')
                  ->references('num')->on('chapter_of_works')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('num_of_work')->comment("작품번호")->unsigned();
            $table->foreign('num_of_work')
                  ->references('num')->on('works')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->string('subsubtitle')->comment("회차제목or회차수");
            $table->text('content')->comment("내용");
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
        Schema::dropIfExists('content_of_works');
    }
}
