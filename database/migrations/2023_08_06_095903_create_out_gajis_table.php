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
            $table->integer('laporan_id')->nullable();
            $table->integer('pengeluaran_id')->nullable();
            $table->string('gaji_keterangan')->nullable();
            $table->integer('gaji_total')->nullable();
            $table->string('gaji_bukti')->nullable();
            $table->enum('status', ['mks', 'sby'])->nullable();
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
