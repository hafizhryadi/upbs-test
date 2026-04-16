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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('kelompok_tani');
            $table->string('alamat');
            $table->string('benih');
            $table->integer('jumlah');
            $table->string('rencana_tanam');
            $table->string('lokasi_lahan');
            $table->integer('luas_lahan');
            $table->string('surat_permohonan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
