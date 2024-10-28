<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('lamarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->constrained()->onDelete('cascade'); // ID mahasiswa
            $table->unsignedBigInteger('mitra_id'); // ID mitra yang menerima lamaran
            $table->foreign('mitra_id')->references('id')->on('mitras')->onDelete('cascade'); // Menambahkan foreign key
            $table->string('cv_path'); // Path ke file CV
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
