<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsradmUsersTable extends Migration
{
    public function up()
    {
        Schema::create('usradm_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('password');
            $table->string('nombres');
            $table->string('paterno');
            $table->string('materno');
            $table->string('email');
            $table->string('unidad')->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('usradm_users');
    }
}
