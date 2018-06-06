<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlantillaSesionSesionVacia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantilla_sesion_sesion_vacia', function (Blueprint $table){
            $table->unsignedInteger('plantilla_sesion_id');
            $table->foreign('plantilla_sesion_id')->references('id')->on('plantillas_sesiones');
            $table->unsignedInteger('sesion_vacia_id');
            $table->foreign('sesion_vacia_id')->references('id')->on('sesion_vacias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantilla_sesion_sesion_vacia');
    }
}
