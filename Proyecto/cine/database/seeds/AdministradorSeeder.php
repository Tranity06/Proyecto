<?php

use Illuminate\Database\Seeder;
use App\Models\Administrador;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Administrador::create([
            'name' => 'Lorena',
            'email' => 'tranity06@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
