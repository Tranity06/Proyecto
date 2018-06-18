<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Factura;
use App\Models\ButacaReservada;
use App\Models\Pelicula;
use App\Models\Sesion;
use App\Models\Producto;
use App\Models\LineaVenta;
use JWTAuth;

class PerfilTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = User::create([
            'id'=> 1,
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'telefono' => 654987321,
            'is_verified' => 1
        ]);

        $factura = Factura::create([
            'fecha' => date('Y-m-d',mktime(0,0,0, date('m'), date('d'), date('Y'))),
            'user_id' => $this->user->id
        ]);

        $pelicula = Pelicula::create([
            'idtmdb' => 299536,
            'titulo' => 'Vengadores: Infinity War',
            'titulo_original' => 'Avengers: Infinity War',
            'estreno' => '2018-04-25',
            'generos' => 'Aventura, Ciencia ficción, Fantasía, Acción',
            'director' => 'Joe Russo, Anthony Russo',
            'actores' => 'Robert Downey Jr., Chris Hemsworth, Mark Ruffalo, Chris Evans, Scarlett Johansson',
            'sinopsis' => 'Vengadores: Infinity War seguirá la lucha de los superhéroes de Marvel contra el mayor villano al que se han enfrentado nunca: Thanos. Su único objetivo será detener a este poderoso antagonista e impedir que se haga con el control de la galaxia. De nuevo veremos al grupo formado por Iron Man, Capitán América, Viuda negra, Ant-Man, Ojo de Halcón, Thor y Hulk, entre otros. En su nueva e impactante aventura, las Gemas del Infinito estarán en juego, unos querrán protegerlas y otros controlarlas, ¿quién ganará?',
            'duracion' => 149,
            'cartel' => 'https://image.tmdb.org/t/p/w342/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg',
            'trailer' => 'https://www.youtube.com/watch?v=wJbudwIF0cE',
            'slider' => 1,
            'slider_image' => 'https://image.tmdb.org/t/p/w500/bOGkgRGdhrBYJSLpXaxhXVstddV.jpg',
            'popularidad' => 604.520984
        ]);

        $sesion = Sesion::create([
            'fecha' => date('Y-m-d',mktime(0,0,0, date('m'), date('d')+1, date('Y'))),
            'hora' => '16:00:00',
            'estado' => 0,
            'pelicula_id' => $pelicula->id,
            'sala_id' => 1,
            'pase' => 1,
        ]);

        $butaca1 = ButacaReservada::create([
            'estado' => 1,
            'sesion_id' => $sesion->id,
            'butaca_id' => 1,
            'factura_id' => $factura->id
        ]);

        $butaca2 = ButacaReservada::create([
            'estado' => 1,
            'sesion_id' => $sesion->id,
            'butaca_id' => 2,
            'factura_id' => $factura->id
        ]);

        $producto1 = Producto::create([
            'nombre' => 'Aquarius',
            'precio' => '1.00',
            'imagen' => '/uploads/productos/aquarius.png',
            'categoria_id' => 1
        ]);

        $producto2 = Producto::create([
            'nombre' => 'Coca-Cola',
            'precio' => '1.00',
            'imagen' => '/uploads/productos/coca-cola.png',
            'categoria_id' => 1
        ]);

        $lineaVenta1 = LineaVenta::create([
            'cantidad' => 2,
            'producto_id' => $producto1->id,
            'factura_id'=> $factura->id
        ]);
        $lineaVenta2 = LineaVenta::create([
            'cantidad' => 1,
            'producto_id' => $producto1->id,
            'factura_id'=> $factura->id
        ]);
    }

    /**********************************************************
     *          RUTA - GET '/tickets'
     **********************************************************/

    /** @test */
    public function error_no_auth(){
        $headers = ['X-CSRF-TOKEN' => csrf_token()];
        $this->get(route('user.tickets'),$headers)
             ->assertStatus(403);
    }

    /** @test */
    public function get_facturas_user(){
        $token = JWTAuth::fromUser($this->user);

        $headers = ['X-CSRF-TOKEN' => csrf_token(),
            'Authorization' => 'Bearer '.$token];

        $this->get(route('user.tickets'),$headers)
             ->assertStatus(200);
    }
}
