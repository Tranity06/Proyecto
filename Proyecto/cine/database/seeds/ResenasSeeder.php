<?php

use Illuminate\Database\Seeder;
use App\Models\Resena;

class ResenasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Resena::class,50)->create();
    }
}
