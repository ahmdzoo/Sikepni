<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Mitra;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamarans';

    protected $fillable = [
        'user_id',
        'mitra_id',
        'cv_path',
    ];

    // Relasi dengan model User (untuk mahasiswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Mitra (untuk mitra)
    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }
}
