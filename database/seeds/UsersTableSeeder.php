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
            'dealer_id' => 2,
            'supervisor_id' => 5
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
            'dealer_id' => 3,
            'supervisor_id' => 8
        ]);

        DB::table('users')->insert([
            'name' => 'tecnico4',
            'email' => 'tec4@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 4,
            'supervisor_id' => 9
        ]);

        DB::table('users')->insert([
            'name' => 'supervisor3',
            'email' => 'super3@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 3,
        ]);
		
        DB::table('users')->insert([
            'name' => 'supervisor4',
            'email' => 'super4@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 4,
        ]);

		DB::table('users')->insert([
            'name' => 'supervisor5',
            'email' => 'super5@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 5,
        ]);

		DB::table('users')->insert([
            'name' => 'supervisor6',
            'email' => 'super6@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 6,
        ]);
        
		DB::table('users')->insert([
            'name' => 'supervisor7',
            'email' => 'super7@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 7,
        ]);

		DB::table('users')->insert([
            'name' => 'supervisor8',
            'email' => 'super8@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 8,
        ]);
        
		DB::table('users')->insert([
            'name' => 'supervisor9',
            'email' => 'super9@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 9,
        ]);
		
		DB::table('users')->insert([
            'name' => 'supervisor10',
            'email' => 'super10@gmail.com',
            'password' => bcrypt('super'),
            'role_id' => 2,
            'dealer_id' => 10,
        ]);
		
		DB::table('users')->insert([
            'name' => 'tecnico5',
            'email' => 'tecnico5@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 5,
            'supervisor_id' => 10			
        ]);	

		DB::table('users')->insert([
            'name' => 'tecnico6',
            'email' => 'tecnico6@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 6,
            'supervisor_id' => 11			
        ]);

		DB::table('users')->insert([
            'name' => 'tecnico7',
            'email' => 'tecnico7@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 7,
            'supervisor_id' => 12			
        ]);

		DB::table('users')->insert([
            'name' => 'tecnico8',
            'email' => 'tecnico8@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 8,
            'supervisor_id' => 13			
        ]);

		DB::table('users')->insert([
            'name' => 'tecnico9',
            'email' => 'tecnico9@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 9,
            'supervisor_id' => 14			
        ]);

		DB::table('users')->insert([
            'name' => 'tecnico10',
            'email' => 'tecnico10@gmail.com',
            'password' => bcrypt('tecnico'),
            'role_id' => 1,
            'dealer_id' => 10,
            'supervisor_id' => 15			
        ]);        
    }
}
