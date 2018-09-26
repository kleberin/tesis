<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'torre',
            'email' => 'torre@gmail.com',
            'password' => bcrypt('torre'),
            'role_id' => 3
        ]);

        DB::table('users')->insert([
            'name' => 'supervisor1',
            'email' => 'super1@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 1
        ]);

        DB::table('users')->insert([
            'name' => 'tecnico1',
            'email' => 'tec1@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 1,
            'supervisor_id' => 2
        ]);

        DB::table('users')->insert([
            'name' => 'tecnico2',
            'email' => 'tec2@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 1,
            'supervisor_id' => 2
        ]);

        DB::table('users')->insert([
            'name' => 'supervisor2',
            'email' => 'super2@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 2
        ]);

        DB::table('users')->insert([
            'name' => 'tecnico3',
            'email' => 'tec3@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 2,
            'supervisor_id' => 5
        ]);

        DB::table('users')->insert([
            'name' => 'tecnico4',
            'email' => 'tec4@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 2,
            'supervisor_id' => 5
        ]);
    }
}
