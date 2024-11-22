<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('jurusan')->nullable()->after('role'); // Tambahkan kolom jurusan
            $table->string('nim')->nullable()->unique()->after('jurusan'); // Tambahkan kolom nim
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jurusan', 'nim']);
        });
    }
};
