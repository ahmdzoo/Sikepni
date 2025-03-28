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
        'tgl_mulai',
        'tgl_selesai',
        'tanggal_mulai_magang',
        'tanggal_selesai_magang',
        'alamat',
        'kuota',
        'status_verifikasi',
        'file_pks',
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

    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'mitra_id'); // Pastikan nama kolom 'mitra_id' sesuai dengan kolom di tabel lamaran
    }
}
