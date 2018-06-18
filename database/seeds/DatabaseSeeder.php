<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Borrar datos de las tablas indicadas
        $this->truncateTables([
            'salas',
            'butacas',
            'sesiones',
            'categorias',
            'productos',
            'ingredientes',
<<<<<<< HEAD
            //'ingrediente_producto',
            'menus',
            'menu_producto',
            //'clave_admin',
=======
            'menus',
            'menu_producto',
>>>>>>> desarrollo
            'administradores',
            'peliculas'
        ]);

        $this->call([
            AdministradorSeeder::class,
            SalaSeeder::class,
            ButacaSeeder::class,
            PeliculasSeeder::class,
            SesionesSeeder::class,
            IngredientesSeeder::class,
            CategoriasSeeder::class,
            MenusSeeder::class,
            ProductosSeeder::class,
<<<<<<< HEAD
            ProductosMenusSeeder::class
=======
>>>>>>> desarrollo
        ]);
    }

    /**
     * Desactiva la restricción de claves foráneas.
     * Borra todos los datos de las tablas pasadas en el array.
     * Reactiva la restriccion de claves foráneas.
     * 
     * Esto permite reejecutar los seeders sin que afectes las restricciones de clave foránea
     */
    protected function truncateTables(array $tables){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach( $tables as $table ){
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
