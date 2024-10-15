<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users (mahasiswa)
            $table->unsignedBigInteger('mitra_id'); // Foreign key ke tabel mitras
            $table->string('cv_path'); // Menyimpan path ke file CV
            $table->timestamps();

            // Definisi Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
