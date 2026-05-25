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
            $table->unsignedBigInteger('variety_id');
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->date('trx_date')->now();
            $table->enum('trx_type', ['masuk', 'keluar'])->default('keluar');
            $table->enum('category', ['penjualan', 'diseminasi'])->nullable();
            $table->integer('quantity');
            $table->text('note')->nullable();
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
