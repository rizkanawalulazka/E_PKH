<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationship dengan model Pendamping
     */
    public function pendamping()
    {
        return $this->hasOne(Pendamping::class);
    }

    /**
     * Relationship dengan model Pendaftaran
     */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    /**
     * Relationship dengan model PencairanDana - TAMBAHKAN INI
     */
    public function pencairanDana()
    {
        return $this->hasMany(PencairanDana::class);
    }

    /**
     * Relationship dengan model AbsensiPertemuan - TAMBAHKAN INI
     */
    public function absensiPertemuan()
    {
        return $this->hasMany(AbsensiPertemuan::class);
    }

    /**
     * Relationship dengan model LaporanBulanan - TAMBAHKAN INI
     */
    public function laporanBulanan()
    {
        return $this->hasMany(LaporanBulanan::class);
    }

    /**
     * Relasi ke model LaporanPendampingan sebagai penerima
     */
    public function laporanPendampingan()
    {
        return $this->hasMany(LaporanPendampingan::class, 'penerima_id');
    }
}
