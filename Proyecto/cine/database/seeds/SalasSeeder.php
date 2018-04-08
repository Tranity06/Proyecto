<?php

use Illuminate\Database\Seeder;
use App\Models\Sala;

class SalasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ( $i=1 ; $i<=10; $i++ ){
            Sala::create([
                'numero' => $i,
            ]);
        }
        
    }
}
