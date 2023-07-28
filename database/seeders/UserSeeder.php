<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'name'          =>  'SUPERADMIN',
            'email'         => 'superadmin@gmail.com',
            'phone_number'  => '08182312319',
            'password'      => bcrypt('password'),
            'role'          => 'superadmin',
            'city'          => 'surabaya',
        ]);

        $superadmin->assignRole('superadmin');

        $admin = User::create([
            'name'          =>  'diki',
            'email'         => 'diki@gmail.com',
            'phone_number'  => '08182312319',
            'password'      => bcrypt('password'),
            'role'          => 'admin',
            'city'          => 'makassar',
        ]);

        $admin->assignRole('admin');
    }
}
