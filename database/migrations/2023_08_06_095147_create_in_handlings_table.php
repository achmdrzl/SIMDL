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
        Schema::create('in_handlings', function (Blueprint $table) {
            $table->id('handling_id');
            $table->integer('laporan_id');
            $table->string('handling_kota');
            $table->integer('handling_tarif');
            $table->integer('handling_berat');
            $table->integer('handling_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('in_handlings');
    }
};
