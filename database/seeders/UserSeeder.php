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

        $superadmin2 = User::create([
            'name'          =>  'Oden Spilner',
            'email'         => 'odenspilner@gmail.com',
            'phone_number'  => '081368881990',
            'password'      => bcrypt('15aug1990'),
            'role'          => 'superadmin',
            'city'          => '-',
        ]);

        $superadmin2->assignRole('superadmin');
    }
}
