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
        'nip',
        'no_hp',
        'alamat',
        'wilayah_kerja',
        'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Pendaftaran (one-to-many)
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'pendamping_id');
    }

    // Method helper untuk menghitung jumlah penerima aktif
    public function jumlahPenerimaAktif()
    {
        return $this->pendaftaran()->where('status', 'approved')->count();
    }
}
