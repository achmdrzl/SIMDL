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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->integer('order_noresi');
            $table->date('order_tanggal');
            $table->string('order_pengirim');
            $table->string('order_penerima');
            $table->string('order_alamat_penerima');
            $table->integer('order_koli');
            $table->string('order_kemasan');
            $table->string('order_rincian');
            $table->integer('order_berat');
            $table->integer('order_volume');
            $table->text('order_isi');
            $table->integer('order_tarif');
            $table->integer('order_total');
            $table->text('order_lampiran');
            $table->text('order_keterangan');
            $table->enum('order_status', ['terdaftar', 'on-progress', 'telah-sampai']);
            $table->integer('order_created')->nullable();
            $table->integer('order_received')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
