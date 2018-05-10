<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    
    public function ver_lista_administradores()
    {
        $this->assertTrue(true);
    }

    public function crear_administrador_con_exito(){

    }

    public function no_crear_admin_si_email_repetodo(){

    }

    public function no_crear_admin_si_nombre_incorrecto(){

    }

    public function no_crear_admin_si_email_incorrecto(){

    }

    public function no_crear_admin_si_contrasena_incorrecta(){

    }

    public function modificar_datos_admin(){

    }

    public function no_modificar_admin_si_email_repetido(){

    }

    public function no_modificar_admin_si_nombre_incorrecto(){

    }

    public function no_modificar_admin_si_email_incorrecto(){

    }

    public function no_modificar_admin_si_contrasena_incorrecta(){

    }

    public function no_modificar_admin_si_no_super_admin(){

    }

    public function si_modificar_perfil_admin_propio(){

    }

    public function borrar_admin(){

    }

    public function no_borrar_admin_si_no_super_admin(){

    }

    public function no_borrar_super_admin(){

    }
}
