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
        Schema::create('out_transportasis', function (Blueprint $table) {
            $table->id('transportasi_id');
            $table->integer('laporan_id');
            $table->string('transportasi_keterangan');
            $table->integer('transportasi_total');
            $table->string('transportasi_bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_transportasis');
    }
};
