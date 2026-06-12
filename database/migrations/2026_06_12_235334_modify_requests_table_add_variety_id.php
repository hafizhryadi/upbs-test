<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add variety_id column
        Schema::table('requests', function (Blueprint $table) {
            $table->unsignedBigInteger('variety_id')->nullable()->after('alamat');
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('variety_id')->references('id')->on('varieties')->nullOnDelete();
        });

        // Migrate data
        $requests = DB::table('requests')->get();
        foreach ($requests as $req) {
            $variety = DB::table('varieties')->where('name', $req->benih)->first();
            if ($variety) {
                DB::table('requests')->where('id', $req->id)->update(['variety_id' => $variety->id]);
            }
        }

        // Drop benih column
        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn('benih');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->string('benih')->nullable()->after('alamat');
        });

        // Restore data
        $requests = DB::table('requests')->whereNotNull('variety_id')->get();
        foreach ($requests as $req) {
            $variety = DB::table('varieties')->where('id', $req->variety_id)->first();
            if ($variety) {
                DB::table('requests')->where('id', $req->id)->update(['benih' => $variety->name]);
            }
        }

        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign(['variety_id']);
            $table->dropColumn('variety_id');
        });
    }
};
