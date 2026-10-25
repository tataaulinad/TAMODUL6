<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $passwordHash = Hash::make('password');

        User::updateOrCreate(
            ['email' => 'admin@floodsense.test'],
            ['name' => 'Admin FloodSense', 'role' => 'admin', 'password' => $passwordHash]
        );

        foreach (range(1, 5) as $number) {
            User::updateOrCreate(
                ['email' => "pengguna{$number}@floodsense.test"],
                [
                    'name' => $faker->name(),
                    'role' => 'user',
                    'password' => $passwordHash,
                ]
            );
        }
    }
}
