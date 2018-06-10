<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSesionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesiones', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->integer('pase', false, true);
            $table->time('hora');
            $table->integer('estado', false, true); //0=Inactiva, 1=Activa

            //Clave foránea PELICULA.
            $table->unsignedInteger('pelicula_id');
            $table->foreign('pelicula_id')->references('id')->on('peliculas');

            //Clave foránea SALA.
            $table->unsignedInteger('sala_id');
            $table->foreign('sala_id')->references('id')->on('salas');

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
        Schema::dropIfExists('sesiones');
    }
}
