<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->date('stok_menipis_dibaca_pada')->nullable()->after('stok');
            $table->date('stok_habis_dibaca_pada')->nullable()->after('stok_menipis_dibaca_pada');
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn(['stok_menipis_dibaca_pada', 'stok_habis_dibaca_pada']);
        });
    }
};
