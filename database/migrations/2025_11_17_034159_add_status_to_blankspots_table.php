<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blankspots', function (Blueprint $table) {
            // Tambahkan kolom status dengan nilai default 'Diusulkan'
            $table->string('status')->default('Diusulkan')->after('lokasi_blankspot');
        });
    }

    public function down(): void
    {
        Schema::table('blankspots', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};