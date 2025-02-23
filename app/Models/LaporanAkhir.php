<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'mitra_id', 'file_path'];


    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function komentar_akhirs()
    {
        return $this->hasMany(KomentarAkhir::class);
    }

    public function scopeForDosen($query, $dosenId)
{
    return $query->whereHas('mahasiswa', function ($q) use ($dosenId) {
        $q->whereHas('dosen', function ($subQuery) use ($dosenId) {
            $subQuery->where('dosen_id', $dosenId);
        });
    });
}


}
