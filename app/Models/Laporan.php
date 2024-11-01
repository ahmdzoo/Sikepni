<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'mitra_id', 'file_path', 'jenis_laporan'];


    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

}

