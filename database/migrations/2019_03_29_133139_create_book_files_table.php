<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_files', function (Blueprint $table) {
            $table->increments('num')->comment("파일번호");
            $table->string('work_title')->comment("작품제목");
            $table->string('subtitle')->comment("챕터제목or권수");
            $table->integer('file_size')->comment("파일사이즈");
            $table->string('file_position')->comment("파일위치");
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
        Schema::dropIfExists('book_files');
    }
}
