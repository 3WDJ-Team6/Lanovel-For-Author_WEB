<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChapterOfWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapter_of_works', function (Blueprint $table) {
            $table->increments('num')->comment("챕터번호");

            $table->integer('num_of_work')->comment("작품번호")->unsigned();
            $table->foreign('num_of_work')
                  ->references('num')->on('works')
                  ->onDelete('cascade')->onUpdate('cascade');
            
            $table->string('subtitle')->comment("챕터제목or권수");
            $table->boolean('check_of_working')->default(0)->comment("작업상황");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapter_of_works');
    }
}
