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
    Schema::create('data_bakti', function (Blueprint $table) {
        $table->id();
        $table->string('kode', 255)->nullable()->unique();
        $table->string('provider', 255)->nullable(); // "Nama"
        $table->string('kelurahan', 255)->nullable();
        $table->string('kecamatan', 255)->nullable();
        $table->text('alamat')->nullable();
        $table->decimal('longitude', 11, 8)->nullable();
        $table->decimal('latitude', 11, 8)->nullable();
        $table->string('status', 255)->nullable();
        $table->integer('tinggi_tower')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_bakti');
    }
};
