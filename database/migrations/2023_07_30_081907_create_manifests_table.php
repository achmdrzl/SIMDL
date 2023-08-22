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
        Schema::create('manifests', function (Blueprint $table) {
            $table->id('manifest_id');
            $table->string('manifest_no');
            $table->date('manifest_tanggal');
            $table->date('manifest_tanggal_awal');
            $table->date('manifest_tanggal_akhir');
            $table->string('manifest_plat_mobil');
            $table->integer('manifest_total_koli');
            $table->integer('manifest_total_berat');
            $table->integer('manifest_total_volume');
            $table->integer('manifest_total_harga');
            $table->enum('manifest_edit_request', ['acc', 'pending'])->default('pending');
            $table->enum('manifest_status', ['manifested', 'delivered'])->default('manifested');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifests');
    }
};
