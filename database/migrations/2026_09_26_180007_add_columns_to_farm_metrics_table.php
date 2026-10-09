<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('farm_metrics', function (Blueprint $table) {
            $table->integer('total_tanaman')->default(0);
            $table->integer('total_lahan')->default(0);
            $table->float('estimasi_panen')->default(0);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('farm_metrics', function (Blueprint $table) {
            //
        });
    }
};
