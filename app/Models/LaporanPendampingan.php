<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPendampingan extends Model
{
    protected $table = 'laporan_pendampingan';
    protected $fillable = [
        'pendamping_id',
        'penerima_id',
        'tanggal',
        'kegiatan',
        'status',
        'foto',
        'verifikasi_status',
        'catatan_admin',
    ];

    public function pendamping()
    {
        return $this->belongsTo(Pendamping::class);
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
}
