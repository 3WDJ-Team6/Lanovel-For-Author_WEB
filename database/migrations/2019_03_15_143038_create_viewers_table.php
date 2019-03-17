<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viewers', function (Blueprint $table) {
            $table->integer('user_id')->comment("회원번호")->unsigned();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            
            $table->integer('font_size')->default(10)->comment("폰트크기");
            $table->string('background_color')->default('#E6E6E6')->comment("배경색");
            $table->string('font_color')->default('#000000')->comment("글자색");
            $table->integer('line_spacing')->default(13)->comment("줄간격");
            $table->string('highlighter_color')->default('#0000FF')->comment("형광펜색");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('viewers');
    }
}
