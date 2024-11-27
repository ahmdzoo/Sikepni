<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('mitras', function (Blueprint $table) {
        $table->date('tanggal_mulai_magang')->nullable();
        $table->date('tanggal_selesai_magang')->nullable();
        $table->string('alamat')->nullable();
        $table->integer('kuota')->nullable();
        $table->string('file_pks')->nullable(); // Untuk path file PDF PKS
    });
}

public function down()
{
    Schema::table('mitras', function (Blueprint $table) {
        $table->dropColumn([
            'tanggal_mulai_magang',
            'tanggal_selesai_magang',
            'alamat',
            'kuota',
            'file_pks',
        ]);
    });
}

};
