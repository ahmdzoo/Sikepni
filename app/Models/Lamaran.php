<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mitra;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mitra_id',
        'cv_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }
}
