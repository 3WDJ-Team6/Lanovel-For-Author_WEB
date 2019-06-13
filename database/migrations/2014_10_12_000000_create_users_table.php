<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // $table->increments('id');
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            $table->increments('id')->comment("회원번호");

            $table->string('email')->unique()->comment("이메일");
            $table->string('password')->comment("비밀번호");
            $table->string('nickname')->unique()->comment("닉네임");

            $table->integer('point')->default(0)->comment("보유포인트");

            $table->string('profile_photo')->nullable()->comment("프로필사진");
            $table->string('introduction_message')->nullable()->comment("소개메시지");

            $table->integer('roles')->default(1)->comment("역할");

            $table->boolean('adult_certification')->default(false)->comment("성인인증여부");

            $table->integer('phone_number')->nullable()->comment("휴대전화번호");
            $table->string('phone_token')->nullable()->comment("기기토큰");

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
