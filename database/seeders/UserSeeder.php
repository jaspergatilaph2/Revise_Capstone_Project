<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                [
                    'name' => 'applicant 1',
                    'email' => 'applicant_1@example.com',
                    'avatar' =>'sneat/img/avatars/1.png',
                    'role' => 'user',
                    'password' => bcrypt('12345678'),
                ],
                [
                    'name' => 'mpdo',
                    'email' => 'mpdo@example.com',
                    'avatar' => 'sneat/img/avatars/2.png',
                    'role' => 'mpdo',
                    'password' => bcrypt('12345678'),
                ],
                [
                    'name' => 'Mr. John Doe',
                    'email' => 'john.doe@example.com',
                    'avatar' => 'sneat/img/avatars/3.png',
                    'role' => 'engineer',
                    'password' => bcrypt('12345678'),
                ],

                [
                    'name' => 'admin',
                    'email' => 'admin@example.com',
                    'avatar' => 'sneat/img/avatars/7.png',
                    'role' => 'admin',
                    'password' => bcrypt('12345678'),
                ]

            ]
        );
    }
}
