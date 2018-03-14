<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeliculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('peliculas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 75);
            $table->string('director', 75); //FK si se crea tabla directores
            $table->string('sinopsis', 200);
            $table->time('duracion');
            $table->string('actores', 75); //FK si se crea tabla actores
            
            $table->unsignedInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('usuarios');

            $table->unsignedInteger('genero_id');
            $table->foreign('genero_id')->references('id')->on('generos');

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
        Schema::dropIfExists('peliculas');
    }
}
