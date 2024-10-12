<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mitra_id',
        'jurusan_id',
        'dosen_pembimbing_id',
        'no_pks',
        'tgl_mulai',
        'tgl_selesai',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    // Relasi
    public function mitraUser()
    {
        return $this->belongsTo(User::class, 'nama_mitra_id');
    }
    // Mitra.php
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id'); // Menggunakan 'jurusan_id' sebagai foreign key
    }


    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }
}
