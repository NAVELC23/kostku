<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamars';
    protected $primaryKey = 'id_kamar';

    protected $fillable = [
        'nomor_kamar',
        'tipe',
        'harga',
        'status',
        'foto',
        // 'fasilitas' dihapus karena sudah dipindah ke tabel terpisah
    ];

    // Relasi Many-to-Many ke Fasilitas
    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_kamar', 'kamar_id', 'fasilitas_id');
    }
}