<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendamping extends Model
{
    use HasFactory;

    protected $table = 'pendamping';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'no_hp',
        'alamat',
        'wilayah_kerja'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Pendaftaran (one-to-many)
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    // Method helper untuk menghitung jumlah penerima aktif
    public function jumlahPenerimaAktif()
    {
        return $this->pendaftaran()->where('status', 'approved')->count();
    }
}
