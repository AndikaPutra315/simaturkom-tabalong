<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_menara', function (Blueprint $table) {
            // Perintah ini menghapus index unik dari kolom 'kode'
            // 'data_menara_kode_unique' adalah nama default yang dibuat Laravel
            $table->dropUnique('data_menara_kode_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_menara', function (Blueprint $table) {
            // Perintah ini menambahkan kembali index unik jika migrasi di-rollback
            $table->unique('kode');
        });
    }
};