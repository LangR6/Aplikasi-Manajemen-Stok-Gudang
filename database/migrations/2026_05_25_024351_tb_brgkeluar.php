<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id('id_barang_keluar');

            // harus nullable karena memakai nullOnDelete()
            $table->string('id_barang', 50)->nullable();

            $table->unsignedInteger('jumlah');
            $table->date('tgl_keluar');
            $table->string('tujuan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // foreign key ke tabel barang kolom kode_barang
            $table->foreign('id_barang')
                ->references('kode_barang')
                ->on('barang')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
