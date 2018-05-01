<?php

use App\Models\Butaca;
use Illuminate\Database\Seeder;

class ButacaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Butaca::class,63)->create();
    }
}
