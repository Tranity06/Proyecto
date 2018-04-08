<?php

use Illuminate\Database\Seeder;
use App\Models\ButacaReservada;

class ButacasReservadasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ButacaReservada::class,40)->create();
    }
}
