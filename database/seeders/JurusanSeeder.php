<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        $jurusans = [
            'Teknik Informatika',
            'Rekayasa Perangkat Lunak',
            'Teknik Pendingin dan Tata Udara',
            'Teknik Mesin',
            'Keperawatan',
            'Perancangan Manufaktur',
            'Sistem Informasi Kota Cerdas',
        ];

        foreach ($jurusans as $jrs) {
            Jurusan::create(['name' => $jrs]);
        }
    }
}
