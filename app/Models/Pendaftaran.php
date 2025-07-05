<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    
    protected $fillable = [
        'user_id',
        'nik',
        'no_kk',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'komponen',
        'kartu_keluarga',
        'foto_rumah',
        'status',
        'catatan_admin',
        'approved_at',
         'pendamping_id'
    ];

    protected $casts = [
        'komponen' => 'array',
        'tanggal_lahir' => 'date',
        'approved_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendamping()
    {
        return $this->belongsTo(Pendamping::class, 'pendamping_id');
    }
}
