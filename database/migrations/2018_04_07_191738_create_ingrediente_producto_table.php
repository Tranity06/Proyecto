<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredienteProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingrediente_producto', function (Blueprint $table) {
            $table->increments('id');

            //Clave foránea PRODUCTO.
            $table->unsignedInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');

            //Clave foránea INGREDIENTE.
            $table->unsignedInteger('ingrediente_id');
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes');

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
        Schema::dropIfExists('ingrediente_producto');
    }
}
