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
    public function run(): void
    {
        User::create([
            'nama' => 'admin',
            'username' => 'prabowo',
            'alamat' => 'SCBD Utara',
            'password' => 'admin',
            'no_telp' => '081234567',
            'NIK' => '0112233445566',
            'foto' => '//uploads//users//admin.jpg',
            'role' => 'admin',
            'kID' => 'K000',
        ]);
    }
}
