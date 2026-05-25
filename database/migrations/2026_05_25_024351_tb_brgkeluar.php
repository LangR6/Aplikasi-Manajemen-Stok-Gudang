<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id('id_barangkeluar');
            $table->foreignId('barang_id')
                  ->constrained('barang')
                  ->cascadeOnDelete();
            $table->foreignId('dicatat_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->unsignedInteger('jumlah');
            $table->date('tgl_keluar');
            $table->string('tujuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            // Tidak pakai softDeletes — hapus transaksi harus rollback stok
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
