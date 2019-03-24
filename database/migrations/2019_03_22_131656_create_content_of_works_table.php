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
            $table->string('subsubtitle')->primary()->comment("회차번호or제목");

            $table->integer('num_of_work')->comment("작품번호")->unsigned();
            $table->foreign('num_of_work')
                  ->references('num')->on('works')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->string('subtitle_of_chapter')->comment("챕터제목or권수");
            $table->foreign('subtitle_of_chapter')
                  ->references('subtitle')->on('chapter_of_works')
                  ->onDelete('cascade')->onUpdate('cascade');
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
