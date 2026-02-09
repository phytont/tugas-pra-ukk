<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory, LogActivity;

    protected $table = 'kategoris';

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function alats()
    {
        return $this->hasMany(Alat::class);
    }
}