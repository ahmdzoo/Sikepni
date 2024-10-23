<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Fungsi untuk memeriksa apakah pengguna adalah Mahasiswa
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }

    // Fungsi untuk memeriksa apakah pengguna adalah Dosen Pembimbing
    public function isDosenPembimbing()
    {
        return $this->role === 'dosen_pembimbing';
    }

    // Fungsi untuk memeriksa apakah pengguna adalah Mitra Magang
    public function isMitraMagang()
    {
        return $this->role === 'mitra_magang';
    }

    // Fungsi untuk memeriksa apakah pengguna adalah Admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Relasi satu ke satu dengan Mitra (jika ada)
    public function mitra()
    {
        return $this->hasOne(Mitra::class, 'nama_mitra'); // Pastikan 'nama_mitra' adalah foreign key yang benar
    }

    public function mitras()
    {
        return $this->hasMany(Mitra::class, 'user_id'); // Ganti 'user_id' dengan nama kolom yang sesuai
    }

    // Relasi satu ke banyak untuk Dosen Pembimbing ke Mitra
    public function mitrasAsDosenPembimbing()
    {
        return $this->hasMany(Mitra::class, 'dosen_pembimbing_id'); // Relasi ke model Mitra
    }

    // Relasi satu ke banyak untuk Mahasiswa ke Lamaran
    public function lamaran()
    {
        return $this->hasMany(Lamaran::class, 'user_id'); // Relasi ke model Lamaran
    }
}
