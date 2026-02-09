<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory, LogActivity;

    protected $table = 'alats';

    protected $fillable = [
        'nama_alat', 'kategori_id', 'merk', 'model', 
        'jumlah_total', 'jumlah_tersedia', 'deskripsi', 'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}