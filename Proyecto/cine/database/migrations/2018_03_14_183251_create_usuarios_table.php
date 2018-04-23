<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->integer('tlf', false, true)->unique();
            $table->string('avatar')->default('default.jpg');
            $table->integer('puntos', false, true)->default('0');
            $table->string('token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
}
