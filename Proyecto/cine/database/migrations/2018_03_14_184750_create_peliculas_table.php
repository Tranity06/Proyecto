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
            $table->unsignedInteger('idtmdb');
            $table->string('titulo');
            $table->string('titulo_original');
            $table->date('estreno')->nullable();
            $table->string('generos')->nullable();
            $table->string('director')->nullable();
            $table->string('actores')->nullable();
            $table->string('sinopsis', 800 )->nullable();
            $table->unsignedInteger('duracion')->nullable();
            $table->string('cartel')->nullable();
            $table->string('trailer')->nullable();
            $table->boolean('slider')->default(0);
            $table->string('slider_image')->nullable();
            
            /*
            //Clave foráneas CALIFICACION_EDAD.
            $table->unsignedInteger('calificacion_edad_id');
            $table->foreign('calificacion_edad_id')->references('id')->on('calificaciones_edades');*/

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
