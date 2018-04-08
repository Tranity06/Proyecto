<?php

use Illuminate\Database\Seeder;
use App\Models\Administrador;

class AdministradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Administrador::class,3)->create();
    }
}
