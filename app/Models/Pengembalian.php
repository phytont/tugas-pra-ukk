<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory, LogActivity;

    protected $table = 'pengembalians';

    protected $fillable = [
        'peminjaman_id', 'tanggal_kembali', 'jumlah_kembali', 
        'kondisi', 'keterangan', 'denda'
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}