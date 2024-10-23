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
        'dosen_pembimbing_id', // Pastikan kolom ini ada di tabel mitra
        'no_pks',
        'tgl_mulai',
        'tgl_selesai',
    ];

    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id'); // Relasi ke User
    }

    public function mitraUser()
    {
        return $this->belongsTo(User::class, 'nama_mitra_id'); 
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id'); // Ganti 'jurusan_id' sesuai nama kolom di tabel
    }
}
