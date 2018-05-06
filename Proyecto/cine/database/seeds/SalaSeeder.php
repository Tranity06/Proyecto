<?php

use App\Models\Sala;
use Illuminate\Database\Seeder;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ( $i=1; $i<=5 ; $i++){
            Sala::create([
                'numero' => $i
            ]);
        }
    }
}
