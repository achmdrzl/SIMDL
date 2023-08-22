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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id('pengeluaran_id');
            $table->date('pengeluaran_tanggal');
            $table->integer('pengeluaran_total_modal');
            $table->integer('pengeluaran_total_operasional');
            $table->integer('pengeluaran_total_transportasi');
            $table->integer('pengeluaran_total_gaji');
            $table->integer('pengeluaran_total');
            $table->integer('pengeluaran_sisa_saldo');
            $table->enum('pengeluaran_edit_request', ['acc', 'pending'])->default('pending');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
