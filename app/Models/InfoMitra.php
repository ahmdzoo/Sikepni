<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoMitra extends Model
{
    use HasFactory;

    protected $table = 'info_mitra'; // Menentukan nama tabel secara eksplisit

    protected $fillable = [
        'nama_mitra',
        'deskripsi',
        'alamat',
        'kontak',
    ];
}
