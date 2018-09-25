<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'técnico'
        ]);

        DB::table('roles')->insert([
            'name' => 'supervisor'
        ]);

        DB::table('roles')->insert([
            'name' => 'torre_control'
        ]);
    }
}
