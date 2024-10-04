<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoMitraTable extends Migration
{
    public function up()
    {
        Schema::create('info_mitra', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mitra');
            $table->text('deskripsi');
            $table->string('alamat');
            $table->string('kontak');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('info_mitra');
    }
}
