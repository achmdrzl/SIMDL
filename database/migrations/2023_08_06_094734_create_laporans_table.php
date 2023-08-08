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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->date('laporan_tanggal');
            $table->date('laporan_tanggal_awal');
            $table->date('laporan_tanggal_akhir');
            $table->integer('laporan_total_omset');
            $table->integer('laporan_total_handling');
            $table->integer('laporan_total_operasional');
            $table->integer('laporan_total_transportasi');
            $table->integer('laporan_total_gaji');
            $table->integer('laporan_total');
            $table->enum('laporan_edit_request', ['acc', 'pending'])->default('pending');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
