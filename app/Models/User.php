<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable; // Pastikan trait Notifiable digunakan

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'jurusan', // Tambahkan jurusan
        'nim', // Tambahkan nim
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

    // Fungsi untuk memeriksa apakah pengguna adalah Admin
    public function isKordinator()
    {
        return $this->role === 'kordinator';
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

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(User::class, 'dosen_mahasiswa', 'dosen_id', 'mahasiswa_id');
    }

    public function dosen()
    {
        return $this->belongsToMany(User::class, 'dosen_mahasiswa', 'mahasiswa_id', 'dosen_id');
    }
}
