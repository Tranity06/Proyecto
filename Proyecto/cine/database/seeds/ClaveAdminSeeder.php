<?php

use Illuminate\Database\Seeder;
use App\Models\ClaveAdmin;

class ClaveAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClaveAdmin::create([
            'password' => bcrypt('admin'),
        ]);
    }
}
