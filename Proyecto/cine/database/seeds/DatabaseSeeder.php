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
            'usuarios',
            'calificaciones_edades',
            'generos',
            'peliculas',
            'resenas',
            'salas',
            'butacas'
        ]);

        //Ejecutar los siguientes Seeders
        $this->call(UsuariosSeeder::class);
        $this->call(CalificacionesEdadesSeeder::class);
        $this->call(GenerosSeeder::class);
        $this->call(PeliculasSeeder::class);
        $this->call(ResenasSeeder::class);
        $this->call(SalasSeeder::class);
        $this->call(ButacasSeeder::class);
    }

    /**
     * Desactiva la restricción de claves foráneas.
     * Borra todos los datos de las tablas pasadas en el array.
     * Reactiva la restriccion de claves foráneas.
     */
    protected function truncateTables(array $tables){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        foreach( $tables as $table ){
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
