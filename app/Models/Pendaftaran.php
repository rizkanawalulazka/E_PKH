<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran'; // Sesuaikan dengan nama tabel
    
    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'komponen',
        'kartu_keluarga',
        'status',
    ];

    protected $casts = [
        'komponen' => 'array', // Penting untuk menyimpan array
        'tanggal_lahir' => 'date'
    ];

    // Relasi dengan user jika diperlukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}