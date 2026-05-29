<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            // menjadikan kode_barang sebagai primary key
            $table->string('kode_barang', 50)->primary();
            $table->string('nama_barang');
            $table->binary('foto_barang')->nullable();
            $table->unsignedInteger('stok')->default(0);
            $table->foreignId('id_kategori')
                  ->nullable()
                  ->constrained('kategori', 'id_kategori')
                  ->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};