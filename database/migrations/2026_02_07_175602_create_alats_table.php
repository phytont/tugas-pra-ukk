<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('merk')->nullable();
            $table->string('model')->nullable();
            $table->integer('jumlah_total')->default(0);
            $table->integer('jumlah_tersedia')->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia', 'dipinjam', 'rusak', 'maintenance'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};