<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory, LogActivity;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id', 
        'alat_id', 
        'jumlah_pinjam', 
        'tanggal_pinjam',
        'tanggal_kembali_rencana', 
        'tanggal_kembali_aktual', 
        'status', 
        'status_persetujuan',
        'approved_by',
        'approved_at',
        'keterangan',
        'status_verifikasi_petugas',
        'tanggal_pengajuan_pengembalian',
        'verified_by_petugas',
        'verified_at_petugas'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'tanggal_pengajuan_pengembalian' => 'date',
        'approved_at' => 'datetime',
        'verified_at_petugas' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function verifiedByPetugas()
    {
        return $this->belongsTo(User::class, 'verified_by_petugas');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }

    // Scope untuk peminjaman yang menunggu persetujuan
    public function scopeMenunggu($query)
    {
        return $query->where('status_persetujuan', 'menunggu');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status_persetujuan', 'disetujui');
    }
}