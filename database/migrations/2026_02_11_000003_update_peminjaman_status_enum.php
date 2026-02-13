<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Disable strict mode temporarily untuk mengizinkan truncate warning
        DB::statement("SET sql_mode=''");
       
        DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('pending_approval', 'menunggu_pengembalian', 'menunggu_verifikasi_pengembalian', 'selesai', 'terlambat') DEFAULT 'pending_approval'");
        
        // Restore strict mode
        DB::statement("SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
    }

    public function down(): void
    {
        DB::statement("SET sql_mode=''");
        
        DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('dipinjam', 'dikembalikan', 'terlambat') DEFAULT 'dipinjam'");
        
        DB::statement("SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
    }
};
