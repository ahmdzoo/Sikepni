<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',  // Using 'user_id' instead of 'mahasiswa_id'
        'mitra_id',
        'cv_path',
    ];

    // Relasi ke User (Mahasiswa)
    public function user()
    {
        return $this->belongsTo(User::class);  // Relasi ke model User
    }

    // Relasi ke InfoMitra
    public function mitra()
    {
        return $this->belongsTo(InfoMitra::class, 'mitra_id');
    }
}
