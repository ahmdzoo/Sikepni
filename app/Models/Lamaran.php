<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamarans';

    protected $fillable = [
        'user_id',
        'mitra_id',
        'cv_path',
        'status',
        'tanggal_diterima',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function dosenPembimbing()
    {
        return $this->belongsTo(User::class, 'dosen_pembimbing_id'); // Relasi ke User
    }
    
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id'); // Pastikan 'user_id' adalah nama kolom yang menyimpan ID mahasiswa
    }

    public function laporan()
{
    return $this->hasMany(Laporan::class, 'mahasiswa_id'); // Pastikan kolom 'mahasiswa_id' sesuai di tabel laporans
}




    
}
