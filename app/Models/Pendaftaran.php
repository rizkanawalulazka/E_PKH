<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'komponen',
        'status',
        'additional_data'
    ];

    protected $casts = [
        'komponen' => 'array',
        'additional_data' => 'array',
        'tanggal_lahir' => 'date'
    ];
} 