<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('farm_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('day'); // Contoh: Senin, Selasa, dll.
            $table->float('actual');
            $table->float('target');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_metrics');
    }
};
