<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('num')->comment("메시지번호");

            $table->integer('num_of_work')->comment("작품번호")->unsigned();
            $table->foreign('num_of_work')
                ->references('num')->on('works')
                ->onDelete('cascade');

            $table->integer('from_id')->comment("보낸회원번호")->unsigned();
            $table->foreign('from_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->integer('to_id')->comment("받는회원번호")->unsigned();
            $table->foreign('to_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->string('message_title')->comment("메시지제목");
            $table->text('message_content')->comment("메시지내용");
            $table->boolean('condition_message')->default(false)->comment("읽음여부");

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
        Schema::dropIfExists('messages');
    }
}
