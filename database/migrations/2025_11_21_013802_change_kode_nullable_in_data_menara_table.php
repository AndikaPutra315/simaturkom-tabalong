<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // PENTING: Jangan lupa import ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Mengubah kolom 'kode' agar BOLEH KOSONG (NULL)
        DB::statement("ALTER TABLE data_menara MODIFY kode VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ke WAJIB ISI (NOT NULL) jika migrasi dibatalkan
        // Pastikan tidak ada data kosong sebelum menjalankan rollback ini nanti
        DB::statement("ALTER TABLE data_menara MODIFY kode VARCHAR(255) NOT NULL");
    }
};
