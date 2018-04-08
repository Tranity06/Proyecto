<?php

use Illuminate\Database\Seeder;
use App\Models\Factura;

class FacturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Factura::class,10)->create();
    }
}
