<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarAkhir extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',   // Assuming this is already there
        'user_id',   // Assuming this is already there
        'laporan_akhir_id', // Add this line
    ];

    // Define relationships if necessary
    public function LaporanAkhir()
    {
        return $this->belongsTo(LaporanAkhir::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
