<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBulanan extends Model
{
    use HasFactory;

    protected $table = 'laporan_bulanan';
    protected $fillable = [
        'user_id', 'bulan', 'tahun', 'kondisi_keluarga', 'pencapaian_komitmen', 
        'kendala', 'rekomendasi', 'pendamping_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendamping()
    {
        return $this->belongsTo(User::class, 'pendamping_id');
    }
}