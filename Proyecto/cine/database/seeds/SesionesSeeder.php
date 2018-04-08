<?php

use Illuminate\Database\Seeder;
use App\Models\Sesion;

class SesionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Sesion::class,50)->create();
    }
}
