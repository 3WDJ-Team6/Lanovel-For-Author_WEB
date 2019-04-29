<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->increments('num')->comment("메모번호");

            $table->integer('num_of_content')->comment("회차번호")->unsigned();
            $table->foreign('num_of_content')
                ->references('num')->on('content_of_works');

            $table->integer('user_id')->comment("메모작성회원아이디")->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->string('content_of_memo')->comment("메모내용");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memos');
    }
}
