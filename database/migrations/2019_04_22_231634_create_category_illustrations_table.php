<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryIllustrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_illustrations', function (Blueprint $table) {

            $table->integer('num_of_illustration')->comment("일러스트번호")->unsigned();
            $table->foreign('num_of_illustration')
                ->references('num')->on('illustration_lists')
                ->onDelete('cascade');

            $table->string('tag')->comment("태그");
            $table->string('moreTag')->comment("세부태그");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_illustrations');
    }
}
