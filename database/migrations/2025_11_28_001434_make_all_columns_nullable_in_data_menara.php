<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        DB::statement("ALTER TABLE data_menara MODIFY provider VARCHAR(255) NULL");
        DB::statement("ALTER TABLE data_menara MODIFY kelurahan VARCHAR(255) NULL");
        DB::statement("ALTER TABLE data_menara MODIFY kecamatan VARCHAR(255) NULL");
        DB::statement("ALTER TABLE data_menara MODIFY alamat TEXT NULL");
        DB::statement("ALTER TABLE data_menara MODIFY longitude DECIMAL(11,8) NULL");
        DB::statement("ALTER TABLE data_menara MODIFY latitude DECIMAL(11,8) NULL");
        DB::statement("ALTER TABLE data_menara MODIFY status VARCHAR(255) NULL");
        DB::statement("ALTER TABLE data_menara MODIFY tinggi_tower INT NULL");

    }

    public function down(): void
    {
        // Tidak perlu diisi untuk kasus ini, karena sulit mengembalikan data null ke not null
    }
};
