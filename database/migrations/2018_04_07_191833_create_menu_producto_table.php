<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_producto', function (Blueprint $table) {
            $table->increments('id');

            //Clave foránea PRODUCTO.
            $table->unsignedInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');

            //Clave foránea MENU.
            $table->unsignedInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_producto');
    }
}
