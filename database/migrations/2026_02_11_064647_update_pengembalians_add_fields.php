<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengembalians', function (Blueprint $table) {
            // Field untuk jenis pelanggaran yang dipilih peminjam
            $table->enum('jenis_pelanggaran', ['tidak_ada', 'telat', 'rusak_ringan', 'hilang'])->default('tidak_ada')->after('kondisi');
            $table->date('tanggal_pengajuan_peminjam')->nullable()->after('jenis_pelanggaran');
            $table->text('keterangan_pelanggaran')->nullable()->after('tanggal_pengajuan_peminjam');
            
            // Field untuk perhitungan otomatis denda telat
            $table->integer('denda_telat_otomatis')->default(0)->after('denda');
            $table->integer('jumlah_hari_telat')->default(0)->after('denda_telat_otomatis');
            
            // Field untuk denda final oleh petugas
            $table->integer('denda_final')->default(0)->after('denda_telat_otomatis');
            $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar')->after('denda_final');
            $table->dateTime('tanggal_pembayaran')->nullable()->after('status_pembayaran');
            $table->foreignId('validated_by_petugas')->nullable()->constrained('users')->after('tanggal_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->dropColumn([
                'jenis_pelanggaran', 'tanggal_pengajuan_peminjam', 'keterangan_pelanggaran',
                'denda_telat_otomatis', 'jumlah_hari_telat', 'denda_final', 
                'status_pembayaran', 'tanggal_pembayaran', 'validated_by_petugas'
            ]);
            
            // Kembalikan field lama
            $table->enum('status_denda', ['menunggu_validasi', 'disetujui', 'ditolak', 'selesai'])->default('selesai');
            $table->foreignId('verified_by_admin')->nullable()->constrained('users');
            $table->dateTime('verified_at_admin')->nullable();
            $table->text('alasan_penolakan_denda')->nullable();
        });
    }
};