<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->date('tanggal_diterima')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropColumn('tanggal_diterima');
        });
    }
};
