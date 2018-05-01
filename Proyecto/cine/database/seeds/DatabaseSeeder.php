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
            /*'usuarios',
            'calificaciones_edades',
            'generos',
            'peliculas',
            'resenas',
            'salas',
            'butacas',
            'sesiones',
            'facturas',
            'butacas_reservadas',
            'categorias',
            'productos',
            'lineas_ventas',
            'ingredientes',
            'ingrediente_producto',
            'menus',
            'administradores',
            'menu_producto',
            'clave_admin',*/
            'administradores',
        ]);

        //Ejecutar los siguientes Seeders
//        $this->call(UsuariosSeeder::class);
//        $this->call(CalificacionesEdadesSeeder::class);
//        $this->call(GenerosSeeder::class);
//        $this->call(PeliculasSeeder::class);
//        $this->call(ResenasSeeder::class);
        $this->call([
            SalaSeeder::class,
            ButacaSeeder::class,
        ]);
//        $this->call(SesionesSeeder::class);
//        $this->call(FacturasSeeder::class);
//        $this->call(ButacasReservadasSeeder::class);
//        $this->call(CategoriasSeeder::class);
//        $this->call(ProductosSeeder::class);
//        $this->call(LineasVentasSeeder::class);
//        $this->call(IngredientesSeeder::class);
//        $this->call(ProductosIngredientesSeeder::class);
//        $this->call(MenusSeeder::class);
//        $this->call(AdministradoresSeeder::class);
//        $this->call(ProductosMenusSeeder::class);
//        $this->call(ClaveAdminSeeder::class);
        $this->call(AdministradorSeeder::class);
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
