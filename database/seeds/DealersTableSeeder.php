<?php

use Illuminate\Database\Seeder;

class DealersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dealers')->insert([
            'name' => 'dealer1',
            'address' => 'Av. Patria y Amazonas',
            'phone' => '3990000',
            'latitude' => -0.207708,
            'longitude' => -78.496828
        ]);

        DB::table('dealers')->insert([
            'name' => 'dealer2',
            'address' => 'Av. Maldonado y Calvas',
            'phone' => '3980000',
            'latitude' => -0.250040,
            'longitude' => -78.520891
        ]);
    }
}
