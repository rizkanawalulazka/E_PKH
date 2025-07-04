<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPertemuan extends Model
{
    use HasFactory;

    protected $table = 'absensi_pertemuan';
    protected $fillable = [
        'user_id', 'bulan', 'tahun', 'status', 'keterangan', 'tanggal_pertemuan'
    ];

    protected $casts = [
        'tanggal_pertemuan' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}