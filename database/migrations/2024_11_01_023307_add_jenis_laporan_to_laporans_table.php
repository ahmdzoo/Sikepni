<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Migration file untuk laporans (tambahkan kolom jenis_laporan)
    public function up()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->string('jenis_laporan')->after('file_path'); // Menyimpan jenis laporan (Harian, Mingguan, atau Bulanan)
        });
    }

    public function down()
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('jenis_laporan');
        });
    }

};
