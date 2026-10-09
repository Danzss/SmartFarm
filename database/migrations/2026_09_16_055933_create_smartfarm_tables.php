<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bagian tabel tanaman dilewati karena sudah ada dari sisi Kotlin

        // 2. Tabel Lahan
        Schema::create('lahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sektor');
            $table->decimal('luas_ha', 5, 2); // Contoh: 6.20 Ha
            $table->string('status')->default('aktif'); // aktif, nonaktif
            $table->timestamps();
        });

        // 3. Tabel Tugas Harian
        Schema::create('tugas_harian', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('prioritas')->default('Rutin'); // Prioritas, Rutin, Selesai
            $table->string('status')->default('pending'); // pending, selesai
            $table->timestamps();
        });

        // 4. Tabel Sensor Telemetri (IoT)
        Schema::create('sensor_telemetri', function (Blueprint $table) {
            $table->id();
            $table->decimal('kelembaban', 5, 2); // e.g. 68.00 %
            $table->decimal('suhu', 5, 2);        // e.g. 26.40 °C
            $table->integer('cahaya');            // e.g. 850 lux
            $table->decimal('ph', 4, 2);          // e.g. 6.50 pH
            $table->timestamps();
        });

        // 5. Tabel Notifikasi / Aktivitas
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('pesan');
            $table->string('tipe')->default('success'); // success, warning, danger, primary
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('sensor_telemetri');
        Schema::dropIfExists('tugas_harian');
        Schema::dropIfExists('lahan');
        // Jangan hapus tanaman di sini agar data Kotlin tetap aman
    }
};