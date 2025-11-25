<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blankspots', function (Blueprint $table) {
            $table->id();
            $table->string('desa')->nullable();
            $table->string('kecamatan');
            $table->string('site')->nullable();
            $table->string('lokasi_blankspot'); // Ini untuk 'titik/lokasi blankspot'
            $table->string('layanan_pendidikan')->nullable();
            $table->string('layanan_kesehatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('blankspots');
    }
};