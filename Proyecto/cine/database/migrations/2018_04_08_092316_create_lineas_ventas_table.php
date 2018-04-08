<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineas_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad',false, true);

            //Clave foránea PRODUCTO.
            $table->unsignedInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');

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
        Schema::dropIfExists('lineas_ventas');
    }
}
