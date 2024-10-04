<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Tambahkan kolom role ke dalam $fillable agar bisa diisi secara massal
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

    public function mitra()
    {
        return $this->hasOne(Mitra::class, 'nama_mitra');
    }

    /**
     * Get the mitras where user is dosen pendamping.
     */
    public function mitrasAsDosenPembimbing()
    {
        return $this->hasMany(Mitra::class, 'dosen_pembimbing');
    }

}
