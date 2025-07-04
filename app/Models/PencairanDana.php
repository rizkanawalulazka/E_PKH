<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencairanDana extends Model
{
    use HasFactory;

    protected $table = 'pencairan_dana';
    protected $fillable = [
        'user_id', 'periode', 'tahun', 'jumlah', 'tanggal_cair', 'status', 'keterangan'
    ];

    protected $casts = [
        'tanggal_cair' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}