<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Erdenebulgan',
            'email' => 'erdenebulgan1011@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123'),
        ]);

        // Create doctor users
        User::create([
            'name' => 'Др. Батбаяр',
            'email' => 'doctor1@healthinfo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('doctor123'),
        ]);
        User::create([
            'name' => 'Др. Оюунчимэг',
            'email' => 'doctor2@healthinfo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('doctor123'),
        ]);

        // Create regular users
        User::create([
            'name' => 'Болд Дорж',
            'email' => 'bold@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user123'),
        ]);

        User::create([
            'name' => 'Туяа Баатар',
            'email' => 'tuyaa@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user123'),
        ]);

        // Create more users using factory
        User::factory(15)->create();
    }

}
