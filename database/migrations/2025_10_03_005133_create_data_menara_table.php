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
        Schema::create('data_menara', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis
            $table->string('kode')->unique(); // Kolom Kode, unik
            $table->string('provider');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->text('alamat'); // Menggunakan text untuk alamat yang mungkin panjang
            $table->decimal('longitude', 11, 8); // Angka desimal untuk presisi koordinat
            $table->decimal('latitude', 11, 8);  // Angka desimal untuk presisi koordinat
            $table->string('tipe_ukuran');
            $table->string('status');
            $table->integer('tinggi_tower'); // Angka bulat untuk tinggi menara
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_menara');
    }
};
