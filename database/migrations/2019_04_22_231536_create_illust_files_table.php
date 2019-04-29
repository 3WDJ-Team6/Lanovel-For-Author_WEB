<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIllustFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('illust_files', function (Blueprint $table) {
            $table->increments('id')->comment("일러스트그림파일번호");

            $table->integer('num_of_illust')->comment("일러스트번호")->nullable()->unsigned();
            $table->foreign('num_of_illust')
                ->references('num')->on('illustration_lists')
                ->onDelete('cascade');

            $table->string('savename_of_illustration')->comment("저장이름");
            $table->string('url_of_illustration')->comment("파일위치");
            $table->string('name_of_illustration')->comment("파일원래이름");
            $table->string('folderPath')->comment("폴더경로");

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
        Schema::dropIfExists('illust_files');
    }
}
