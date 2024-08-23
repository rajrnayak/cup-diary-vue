<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{

    public function run(): void
    {

        Role::truncate();
        User::truncate();

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name'=> 'Admin',
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'display_name'=> 'User',
        ]);

        $user1 = User::create([
            'username' => 'admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'mobile_number' => 9876543210,
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $user1->assignRole($adminRole->name);

        $faker = Factory::create();

        for ($count = 0; $count < 38; $count++) {

            $row = User::create([
                'username' => $faker->name(),
                'first_name' => $faker->name(),
                'last_name' => $faker->name(),
                'mobile_number' => 9904427380,
                'email' => $faker->safeEmail(),
                'password' => Hash::make('123456'),
            ]);

            $row->assignRole($userRole->name);
        }
    }
}
