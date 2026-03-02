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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id');
            $table->date('trx_date')->now();
            $table->enum('trx_type', ['masuk', 'keluar']);
            $table->enum('category', ['Produksi', 'Penjualan', 'Subsidi', 'Transfer', 'Koreksi', 'Retur']);
            $table->integer('quantity');
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
