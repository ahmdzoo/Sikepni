<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('laporan_akhirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
            $table->string('file_path'); // Untuk menyimpan path file laporan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_akhirs');
    }
};
