<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update enum kondisi untuk menambahkan 'hilang'
        Schema::table('pengembalians', function (Blueprint $table) {
            // MySQL: Ubah enum menjadi memiliki nilai baru termasuk 'hilang'
            DB::statement("ALTER TABLE pengembalians MODIFY kondisi ENUM('baik', 'rusak_ringan', 'rusak_berat', 'hilang') DEFAULT 'baik'");
        });
    }

    public function down(): void
    {
        // Kembalikan ke enum lama tanpa 'hilang'
        Schema::table('pengembalians', function (Blueprint $table) {
            DB::statement("ALTER TABLE pengembalians MODIFY kondisi ENUM('baik', 'rusak_ringan', 'rusak_berat') DEFAULT 'baik'");
        });
    }
};
