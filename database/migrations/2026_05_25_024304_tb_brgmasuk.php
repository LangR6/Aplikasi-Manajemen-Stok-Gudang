<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id('id_barang_masuk');

            // harus nullable karena memakai nullOnDelete()
            $table->string('id_barang', 50)->nullable();

            $table->unsignedBigInteger('id_supplier')->nullable();

            $table->unsignedInteger('jumlah');
            $table->date('tgl_masuk');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // foreign key ke barang.kode_barang
            $table->foreign('id_barang')
                ->references('kode_barang')
                ->on('barang')
                ->nullOnDelete();

            // foreign key ke supplier
            $table->foreign('id_supplier')
                ->references('id_supplier')
                ->on('supplier')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
