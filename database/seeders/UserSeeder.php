<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pendamping;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin Account
        User::create([
            'nik' => '1111111111111111',
            'name' => 'Administrator',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Create Pendamping Account
        $pendamping = User::create([
            'nik' => '2222222222222222',
            'name' => 'Pendamping PKH',
            'password' => Hash::make('pendamping123'),
            'role' => 'pendamping'
        ]);

        // Create Pendamping Profile
        Pendamping::create([
            'user_id' => $pendamping->id,
            'nama_lengkap' => 'Pendamping PKH',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. Contoh No. 123',
            'wilayah_kerja' => 'Kecamatan Contoh'
        ]);
    }
} 