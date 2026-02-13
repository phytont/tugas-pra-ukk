<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update enum status pada peminjamans
        Schema::table('peminjamans', function (Blueprint $table) {
            // Tambah kolom baru untuk status persetujuan
            $table->enum('status_verifikasi_petugas', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            $table->date('tanggal_pengajuan_pengembalian')->nullable()->after('tanggal_kembali_aktual');
            $table->unsignedBigInteger('verified_by_petugas')->nullable()->after('tanggal_pengajuan_pengembalian');
            $table->timestamp('verified_at_petugas')->nullable()->after('verified_by_petugas');
        });

        // Update enum status pada pengembalians
        Schema::table('pengembalians', function (Blueprint $table) {
            $table->enum('status_denda', ['menunggu_validasi', 'disetujui', 'ditolak', 'selesai'])->default('selesai')->after('denda');
            $table->unsignedBigInteger('verified_by_admin')->nullable()->after('status_denda');
            $table->timestamp('verified_at_admin')->nullable()->after('verified_by_admin');
            $table->text('alasan_penolakan_denda')->nullable()->after('verified_at_admin');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi_petugas', 'tanggal_pengajuan_pengembalian', 'verified_by_petugas', 'verified_at_petugas']);
        });

        Schema::table('pengembalians', function (Blueprint $table) {
            $table->dropColumn(['status_denda', 'verified_by_admin', 'verified_at_admin', 'alasan_penolakan_denda']);
        });
    }
};
