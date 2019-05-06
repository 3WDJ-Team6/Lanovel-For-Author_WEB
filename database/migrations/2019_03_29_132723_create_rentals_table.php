<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->increments('num')->comment("구매및대여번호");

            $table->integer('user_id')->comment("회원번호")->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('num_of_work')->comment("작품번호")->unsigned();
            $table->foreign('num_of_work')
                ->references('num')->on('works')
                ->onDelete('cascade');

            $table->dateTime('due_of_rental')->nullable()->comment("대여날짜");
            $table->string('file_path')->nullable()->comment("파일경로");
            $table->integer('chapter_of_work')->comment("회차,권");
            $table->date('onlyDate')->useCurrent()->comment("날짜");
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
        Schema::dropIfExists('rentals');
    }
}
