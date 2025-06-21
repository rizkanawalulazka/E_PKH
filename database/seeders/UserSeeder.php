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

        // Create multiple Pendamping Accounts and Profiles (10 unique)
        $dummyPendampingUsers = [
            [
                'nik' => '9000000000000001',
                'name' => 'Budi Santoso',
                'password' => Hash::make('pendamping1'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Budi Santoso',
                    'no_hp' => '081234567890',
                    'alamat' => 'Jl. Melati No. 10, Jakarta',
                    'wilayah_kerja' => 'Jakarta Selatan',
                ]
            ],
            [
                'nik' => '9000000000000002',
                'name' => 'Siti Aminah',
                'password' => Hash::make('pendamping2'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Siti Aminah',
                    'no_hp' => '081298765432',
                    'alamat' => 'Jl. Kenanga No. 5, Bandung',
                    'wilayah_kerja' => 'Bandung Timur',
                ]
            ],
            [
                'nik' => '9000000000000003',
                'name' => 'Agus Prabowo',
                'password' => Hash::make('pendamping3'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Agus Prabowo',
                    'no_hp' => '081377788899',
                    'alamat' => 'Jl. Mawar No. 7, Surabaya',
                    'wilayah_kerja' => 'Surabaya Barat',
                ]
            ],
            [
                'nik' => '9000000000000004',
                'name' => 'Dewi Lestari',
                'password' => Hash::make('pendamping4'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Dewi Lestari',
                    'no_hp' => '081355566677',
                    'alamat' => 'Jl. Anggrek No. 3, Yogyakarta',
                    'wilayah_kerja' => 'Yogyakarta Kota',
                ]
            ],
            [
                'nik' => '9000000000000005',
                'name' => 'Rina Wulandari',
                'password' => Hash::make('pendamping5'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Rina Wulandari',
                    'no_hp' => '081234567891',
                    'alamat' => 'Jl. Flamboyan No. 8, Medan',
                    'wilayah_kerja' => 'Medan Kota',
                ]
            ],
            [
                'nik' => '9000000000000006',
                'name' => 'Eko Saputra',
                'password' => Hash::make('pendamping6'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Eko Saputra',
                    'no_hp' => '081234567892',
                    'alamat' => 'Jl. Cemara No. 12, Semarang',
                    'wilayah_kerja' => 'Semarang Tengah',
                ]
            ],
            [
                'nik' => '9000000000000007',
                'name' => 'Linda Sari',
                'password' => Hash::make('pendamping7'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Linda Sari',
                    'no_hp' => '081234567893',
                    'alamat' => 'Jl. Dahlia No. 15, Makassar',
                    'wilayah_kerja' => 'Makassar Barat',
                ]
            ],
            [
                'nik' => '9000000000000008',
                'name' => 'Yusuf Hidayat',
                'password' => Hash::make('pendamping8'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Yusuf Hidayat',
                    'no_hp' => '081234567894',
                    'alamat' => 'Jl. Teratai No. 20, Palembang',
                    'wilayah_kerja' => 'Palembang Timur',
                ]
            ],
            [
                'nik' => '9000000000000009',
                'name' => 'Sari Dewi',
                'password' => Hash::make('pendamping9'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Sari Dewi',
                    'no_hp' => '081234567895',
                    'alamat' => 'Jl. Kamboja No. 25, Balikpapan',
                    'wilayah_kerja' => 'Balikpapan Selatan',
                ]
            ],
            [
                'nik' => '9000000000000010',
                'name' => 'Rahmat Fadli',
                'password' => Hash::make('pendamping10'),
                'role' => 'pendamping',
                'profile' => [
                    'nama_lengkap' => 'Rahmat Fadli',
                    'no_hp' => '081234567896',
                    'alamat' => 'Jl. Bougenville No. 30, Malang',
                    'wilayah_kerja' => 'Malang Utara',
                ]
            ],
        ];

        foreach ($dummyPendampingUsers as $userData) {
            $user = User::create([
                'nik' => $userData['nik'],
                'name' => $userData['name'],
                'password' => $userData['password'],
                'role' => $userData['role'],
            ]);
            Pendamping::create(array_merge($userData['profile'], ['user_id' => $user->id]));
        }
    }
} 