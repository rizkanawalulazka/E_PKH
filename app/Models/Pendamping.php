<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendamping extends Model
{
    protected $table = 'pendamping';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'no_hp',
        'alamat',
        'wilayah_kerja'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function laporanPendampingan()
    // {
    //     return $this->hasMany(LaporanPendampingan::class);
    // }
}
