<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'username' => 'raj',
            'first_name' => 'Raj',
            'last_name' => 'Nayak',
            'mobile_number' => 8320139615,
            'email' => 'raj@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $user2 = User::create([
            'username' => 'mahir',
            'first_name' => 'Mahir',
            'last_name' => 'Sherasiya',
            'mobile_number' => 9904427380,
            'email' => 'sherasiyamahir24@gmail.com',
            'password' => bcrypt('123456'),
        ]);

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

        }
    }
}
