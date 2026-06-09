<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihans';

    // Disesuaikan dengan kolom di migration kamu
    protected $fillable = [
        'user_id',
        'bulan',
        'nominal_tagihan',
        'status',
    ];

    // Relasi langsung ke data User/Akun Penghuni
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}