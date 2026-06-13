<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghunis';
    protected $primaryKey = 'id_penghuni';

    protected $fillable = [
        'id_user',
        'id_kamar',
        'tanggal_masuk',
        'status_penghuni',
        'tanggal_keluar',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke Kamar
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_penghuni', 'id_penghuni');
    }
    public function perbaikans()
    {
        return $this->hasMany(Perbaikan::class, 'id_penghuni', 'id_penghuni');
    }   
}