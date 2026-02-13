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
        'peminjaman_id', 
        'tanggal_kembali', 
        'jumlah_kembali', 
        'kondisi', 
        'jenis_pelanggaran',
        'tanggal_pengajuan_peminjam',
        'keterangan_pelanggaran',
        'keterangan',
        'denda',
        'denda_telat_otomatis',
        'jumlah_hari_telat',
        'denda_final',
        'status_pembayaran',
        'tanggal_pembayaran',
        'validated_by_petugas'
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'tanggal_pengajuan_peminjam' => 'date',
        'tanggal_pembayaran' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function validatedByPetugas()
    {
        return $this->belongsTo(User::class, 'validated_by_petugas');
    }

    // Helper untuk total denda yang harus dibayar
    public function getTotalDendaAttribute()
    {
        return $this->denda_telat_otomatis + $this->denda_final;
    }

    // Scope untuk denda yang belum dibayar
    public function scopeBelumDibayar($query)
    {
        return $query->where('status_pembayaran', 'belum_bayar');
    }

    // Scope untuk denda yang sudah dibayar
    public function scopeSudahDibayar($query)
    {
        return $query->where('status_pembayaran', 'sudah_bayar');
    }
}