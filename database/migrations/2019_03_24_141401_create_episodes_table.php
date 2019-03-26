<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('num')->comment("에피소드번호");

            $table->integer('num_of_content')->comment("회차번호")->unsigned();
            $table->foreign('num_of_content')
                  ->references('num')->on('content_of_works')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->string('episode_title')->comment("에피소드제목");
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
        Schema::dropIfExists('episodes');
    }
}
