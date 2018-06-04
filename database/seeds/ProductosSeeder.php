<?php

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bebidas = Categoria::find(1);
        $patatas = Categoria::find(2);
        $choco = Categoria::find(3);
        $caliente = Categoria::find(4);
        
        Producto::create([
            'nombre' => 'Aquarius',
            'precio' => '1.00',
            'imagen' => '/uploads/productos/aquarius.png',
            'categoria_id' => $bebidas->id
        ]);

        Producto::create([
            'nombre' => 'Coca-Cola',
            'precio' => '1.00',
            'imagen' => '/uploads/productos/coca-cola.png',
            'categoria_id' => $bebidas->id
        ]);

        Producto::create([
            'nombre' => 'Fanta',
            'precio' => '1.00',
            'imagen' => '/uploads/productos/fanta.png',
            'categoria_id' => $bebidas->id
        ]);

        Producto::create([
            'nombre' => 'Monster',
            'precio' => '1.50',
            'imagen' => '/uploads/productos/monster.png',
            'categoria_id' => $bebidas->id
        ]);

        Producto::create([
            'nombre' => 'Boca Bits',
            'precio' => '1.50',
            'imagen' => '/uploads/productos/boca-bits.png',
            'categoria_id' => $patatas->id
        ]);

        Producto::create([
            'nombre' => 'Gusanitos',
            'precio' => '1.25',
            'imagen' => '/uploads/productos/gusanitos.png',
            'categoria_id' => $patatas->id
        ]);

        Producto::create([
            'nombre' => 'Patatas Fritas',
            'precio' => '1.50',
            'imagen' => '/uploads/productos/patatas.png',
            'categoria_id' => $patatas->id
        ]);

        Producto::create([
            'nombre' => 'Bollicaos Mini',
            'precio' => '1.75',
            'imagen' => '/uploads/productos/bollicao-mini.png',
            'categoria_id' => $choco->id
        ]);

        Producto::create([
            'nombre' => 'Donuts Choco',
            'precio' => '1.85',
            'imagen' => '/uploads/productos/donuts-choco.png',
            'categoria_id' => $choco->id
        ]);

        Producto::create([
            'nombre' => 'Kinder Bueno',
            'precio' => '1.50',
            'imagen' => '/uploads/productos/kinder-bueno.png',
            'categoria_id' => $choco->id
        ]);

        Producto::create([
            'nombre' => 'Kinder Maxi',
            'precio' => '3.15',
            'imagen' => '/uploads/productos/kinder-maxi.png',
            'categoria_id' => $choco->id
        ]);

        Producto::create([
            'nombre' => 'Kit Kat',
            'precio' => '1.50',
            'imagen' => '/uploads/productos/kit-kat.png',
            'categoria_id' => $choco->id
        ]);

        Producto::create([
            'nombre' => 'Mikado',
            'precio' => '1.65',
            'imagen' => '/uploads/productos/mikado.png',
            'categoria_id' => $choco->id
        ]);

        Producto::create([
            'nombre' => 'Oreo Mini',
            'precio' => '1.75',
            'imagen' => '/uploads/productos/oreo-mini.png',
            'categoria_id' => $choco->id
        ]);

        Producto::create([
            'nombre' => 'Hamburguesa',
            'precio' => '3.50',
            'imagen' => '/uploads/productos/hamburguesa.png',
            'categoria_id' => $caliente->id
        ]);

        Producto::create([
            'nombre' => 'Pizza',
            'precio' => '3.50',
            'imagen' => '/uploads/productos/pizza.png',
            'categoria_id' => $caliente->id
        ]);

        Producto::create([
            'nombre' => 'Perrito Caliente',
            'precio' => '2.50',
            'imagen' => '/uploads/productos/perrito-caliente.png',
            'categoria_id' => $caliente->id
        ]);

    }
}
