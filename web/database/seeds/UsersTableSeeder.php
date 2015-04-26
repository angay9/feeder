<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use Faker\Factory as Faker;
use Feeder\Models\User;
use Feeder\Models\Device;
use \DB;

class UsersTableSeeder extends Seeder {

    public function run()
    {
    	$faker = Faker::create();

        foreach (range(1, 50) as $i) 
        {
        	$createAdmin = $i == 1;

        	DB::transaction(function () use ($faker, $createAdmin) {

				$user = User::create([
					'name'	=>	$faker->name,
					'email'	=>	$createAdmin ? 'admin@admin.com' : $faker->email,
					'password'	=>	$createAdmin ? bcrypt('admin') : bcrypt($faker->password),
					'role'	=>	$createAdmin ? User::ROLE_ADMIN : User::ROLE_USER
				]);

				// Admin doesn't need the device
				if (!$createAdmin) 
				{
					$user->devices()->save(new Device(['guid' => $faker->uuid]));
				}

			});
        }
    }

}