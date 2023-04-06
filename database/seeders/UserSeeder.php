<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'User',
            'email' => 'user@gmail.com',
            'password' => '123456',
            'is_active' => 1,
        ])->assignRole('User');

        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '123456',
        ])->assignRole('Admin');
    }
}
