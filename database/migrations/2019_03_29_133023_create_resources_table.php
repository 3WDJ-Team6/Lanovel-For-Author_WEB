<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id')->comment("파일id");

            $table->string('user_email')->comment("회원이메일");
            $table->foreign('user_email')
                ->references('email')->on('users')
                ->onDelete('cascade');

            $table->string('name')->comment("파일명");
            $table->integer('size')->comment("파일사이즈");
            $table->string('path')->comment("파일위치");
            $table->string('src')->comment("파일소스");
            $table->string('type')->comment("파일타입");
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
        Schema::dropIfExists('resources');
    }
}
