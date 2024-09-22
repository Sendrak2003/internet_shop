<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'passportNumber' => '1234567890',
            'firstName' => 'User',
            'lastName' => 'One',
            'login' => 'user1',
            'email' => 'user1@example.com',
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null,
            'address' => '123 Main St',
            'phoneNumber' => '1234567890',
            'dateOfBirth' => '1990-01-01',
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'passportNumber' => '0987654321',
            'firstName' => 'Admin',
            'lastName' => 'One',
            'login' => 'admin1',
            'email' => 'admin1@example.com',
            'email_verified_at' => null,
            'password' => bcrypt('password'),
            'remember_token' => null,
            'address' => '123 Main St',
            'phoneNumber' => '1234567890',
            'dateOfBirth' => '1990-01-01',
            'role_id' => 1,
        ]);
    }
}
