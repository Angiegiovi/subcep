<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmTareasTable extends Migration
{
    public function up()
    {
        Schema::create('adm_tareas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cod_tarea')->nullable();
            $table->string('nombre_tarea')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('fecha_ini')->nullable();
            $table->string('fecha_fin')->nullable();
            $table->integer('usuario_id')->unsigned();
            $table->integer('revisor1_id')->unsigned()->nullable();
            $table->integer('aprobacion1_id')->unsigned()->nullable();
            $table->integer('revisor2_id')->unsigned()->nullable();
            $table->integer('aprobacion2_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down()
    {
        Schema::dropIfExists('adm_tareas');
    }
}
