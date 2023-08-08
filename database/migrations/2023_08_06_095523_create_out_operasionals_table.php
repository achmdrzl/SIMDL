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
        Schema::create('out_operasionals', function (Blueprint $table) {
            $table->id('operasional_id');
            $table->integer('laporan_id');
            $table->string('operasional_keterangan');
            $table->integer('operasional_total');
            $table->string('operasional_bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_operasionals');
    }
};
