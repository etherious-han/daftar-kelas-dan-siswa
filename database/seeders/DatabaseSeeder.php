<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
        public function run()
    {
        // User Admin
        \App\Models\User::create([
            'name' => 'Admin',
            'username' => 'admin', // wajib diisi
            'password' => '123456',
            'role' => 'admin',
        ]);

        // User Siswa
        \App\Models\User::create([
            'name' => 'Siswa',
            'username' => 'siswa', // wajib diisi
            'password' => '123456',
            'role' => 'siswa',
        ]);
    }

}
