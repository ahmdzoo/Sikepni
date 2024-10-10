<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_pks',
        'tgl_mulai',
        'tgl_selesai',
        'nama_mitra_id',
        'jurusan_id',
        'dosen_pembimbing_id',
    ];

    /**
     * Get the user that owns the mitra.
     */
    public function mitraUser()
    {
        return $this->belongsTo(User::class, 'nama_mitra_id');
    }

    /**
     * Get the jurusan associated with the mitra.
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Get the dosen pembimbing associated with the mitra.
     */
    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id');
    }
}
