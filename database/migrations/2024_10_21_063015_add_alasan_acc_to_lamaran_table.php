<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->text('alasan_acc')->nullable(); // Menambahkan kolom untuk alasan diterima
        });
    }

    public function down()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropColumn('alasan_acc'); // Menghapus kolom saat rollback
        });
    }

};
