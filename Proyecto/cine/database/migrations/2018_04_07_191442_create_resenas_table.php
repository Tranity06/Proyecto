<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resenas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('valoracion');
            $table->string('comentario');

            //Clave foránea USUARIO.
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            //Clave foránea PELICULA.
            $table->unsignedInteger('pelicula_id');
            $table->foreign('pelicula_id')->references('id')->on('peliculas');

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
        Schema::dropIfExists('resenas');
    }
}
