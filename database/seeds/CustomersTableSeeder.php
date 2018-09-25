<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'reference_number' => 1700000001,
            'name' => 'Juan Perez',
            'address' => 'Tomás de Berlanga y Shyris',
            'phone' => '2222000',
            'latitude' => -0.165276,
            'longitude' => 78.479246
        ]);

        DB::table('customers')->insert([
            'reference_number' => 1700000002,
            'name' => 'Ana Gonzalez',
            'address' => 'Real Audiencia y Borrero',
            'phone' => '2221000',
            'latitude' => -0.132906,
            'longitude' => -78.486756
        ]);

        DB::table('customers')->insert([
            'reference_number' => 1700000003,
            'name' => 'Lucila Vasquez',
            'address' => 'Rocafuerte y Manosalvas',
            'phone' => '2223000',
            'latitude' => -0.226132,
            'longitude' => -78.511486
        ]);

        DB::table('customers')->insert([
            'reference_number' => 1700000004,
            'name' => 'Diego Lopez',
            'address' => 'Teniente Hugo Ortiz y Yeira',
            'phone' => '2224000',
            'latitude' => -0.252138,
            'longitude' =>  -78.531192
        ]);

        DB::table('customers')->insert([
            'reference_number' => 1700000005,
            'name' => 'Maria Enriquez',
            'address' => 'Cusubamba',
            'phone' => '2225000',
            'latitude' => -0.279821,
            'longitude' =>  -78.537311
        ]);
    }
}
