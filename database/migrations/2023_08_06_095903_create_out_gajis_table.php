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
        Schema::create('out_gajis', function (Blueprint $table) {
            $table->id('gaji_id');
            $table->integer('laporan_id');
            $table->string('gaji_keterangan');
            $table->integer('gaji_total');
            $table->string('gaji_bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_gajis');
    }
};
