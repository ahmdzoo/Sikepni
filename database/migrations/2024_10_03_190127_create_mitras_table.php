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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('no_pks');
            $table->date('tgl_mulai'); // Tanggal mulai kerjasama
            $table->date('tgl_selesai'); // Tanggal berakhirnya kerjasama
            $table->unsignedBigInteger('nama_mitra_id'); // Foreign key ke tabel users (role mitra_magang)
            $table->unsignedBigInteger('jurusan_id'); // Foreign key ke tabel jurusans
            $table->timestamps();

            // Definisi Foreign Key
            $table->foreign('nama_mitra_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
            $table->foreign('dosen_pembimbing_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
