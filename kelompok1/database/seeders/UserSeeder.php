<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Admin Utama',
                'email'     => 'admin@edrent.com',
                'password'  => bcrypt('admin123'),
                'whatsapp'  => '081122334455',
                'ktp'       => '3404000000000000', 
                'sim'       => null,               
                'role'      => 'admin',            
            ],
            [
                'name'      => 'Demo User',
                'email'     => 'demo@edrent.com',
                'password'  => bcrypt('password'),
                'whatsapp'  => '08123456789',
                'ktp'       => '3404010101900001',
                'sim'       => 'C-1234567890',
            ],
            [
                'name'      => 'Budi Santoso',
                'email'     => 'budi@mail.com',
                'password'  => bcrypt('password'),
                'whatsapp'  => '08234567890',
                'ktp'       => '3404010202900002',
                'sim'       => 'C-0987654321',
            ],
            [
                'name'      => 'Sari Dewi',
                'email'     => 'sari@mail.com',
                'password'  => bcrypt('password'),
                'whatsapp'  => '08345678901',
                'ktp'       => '3404010303900003',
                'sim'       => 'C-1122334455',
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
