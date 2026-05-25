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
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('batch_code')->nullable()->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('batch_code')->nullable()->after('variety_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('batch_code')->nullable(false)->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('batch_code');
        });
    }
};
