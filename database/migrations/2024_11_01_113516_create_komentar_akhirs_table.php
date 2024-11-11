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
        Schema::create('komentar_akhirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_akhir_id');
            $table->unsignedBigInteger('user_id'); // ID pengguna yang memberikan komentar
            $table->text('content');
            $table->timestamps();
        
            $table->foreign('laporan_akhir_id')->references('id')->on('laporan_akhirs')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_akhirs');
    }
};
