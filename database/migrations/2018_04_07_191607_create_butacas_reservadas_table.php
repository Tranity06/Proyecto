<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateButacasReservadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('butacas_reservadas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estado', false, true); //0=Libre, 1=Seleccionada, 2=Reservada

            //Clave foránea SESION.
            $table->unsignedInteger('sesion_id');
            $table->foreign('sesion_id')->references('id')->on('sesiones');

            //Clave foránea BUTACA.
            $table->unsignedInteger('butaca_id');
            $table->foreign('butaca_id')->references('id')->on('butacas');

            //Clave foránea FACTURA.
            $table->unsignedInteger('factura_id');
            $table->foreign('factura_id')->references('id')->on('facturas');

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
        Schema::dropIfExists('butacas_reservadas');
    }
}
