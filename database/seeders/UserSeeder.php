<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'jurusan' => null,
            'nim' => null,
        ]);

        // Kordinator
        User::create([
            'name' => 'Koordinator Magang',
            'email' => 'koordinator@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'kordinator',
            'jurusan' => null,
            'nim' => null,
        ]);

        // Dosen Pembimbing
        User::create([
            'name' => 'Dosen Pembimbing 1',
            'email' => 'dosen1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'dosen_pembimbing',
            'jurusan' => 'Teknik Informatika',
            'nim' => null,
        ]);

        // Mitra Magang
        User::create([
            'name' => 'PT Mitra Jaya',
            'email' => 'mitra@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'mitra_magang',
            'jurusan' => null,
            'nim' => null,
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa A',
            'email' => 'mahasiswa1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'mahasiswa',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'nim' => '210101001',
        ]);

        User::create([
            'name' => 'Mahasiswa B',
            'email' => 'mahasiswa2@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'mahasiswa',
            'jurusan' => 'Teknik Informatika',
            'nim' => '210101002',
        ]);
    }
}
