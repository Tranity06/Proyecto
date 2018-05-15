<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButacasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('butacas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fila', false, true);
            $table->integer('numero', false, true);
            $table->integer('estado', false, true); // 0=libre , 1=reservada

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
        Schema::dropIfExists('butacas');
    }
}
