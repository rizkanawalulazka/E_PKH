<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran'; // pastikan nama tabel sesuai di database
    
    protected $fillable = [
        'user_id',
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'komponen',
        'kartu_keluarga',
        'status',
        'catatan_admin',
        'approved_at',
    ];

    protected $casts = [
        'komponen' => 'array', // Penting untuk menyimpan array
        'tanggal_lahir' => 'date',
        'approved_at' => 'datetime'
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
