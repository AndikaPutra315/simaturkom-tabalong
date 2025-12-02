<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blankspots', function (Blueprint $table) {

            $table->string('latitude')->nullable()->after('site');
            $table->string('longitude')->nullable()->after('latitude');

            $table->dropColumn('lokasi_blankspot');
        });
    }

    public function down(): void
    {
        Schema::table('blankspots', function (Blueprint $table) {
            $table->string('lokasi_blankspot')->nullable();
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
