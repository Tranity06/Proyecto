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
            $table->string('titulo');
            $table->string('director'); //FK si se crea tabla directores
            $table->string('sinopsis');
            $table->time('duracion');
            $table->string('actores'); //FK si se crea tabla actores
            $table->string('cartel');
            
            //Clave foránea GENEROS.
            $table->unsignedInteger('genero_id');
            $table->foreign('genero_id')->references('id')->on('generos');

            //Clave foráneas CALIFICACION_EDAD.
            $table->unsignedInteger('calificacion_edad_id');
            $table->foreign('calificacion_edad_id')->references('id')->on('calificaciones_edades');

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
