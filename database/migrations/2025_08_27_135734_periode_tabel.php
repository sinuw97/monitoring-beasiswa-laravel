<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->char('semester_id', 8)->primary();
            $table->string('tahun_akademik')->nullable(false);
            $table->enum('semester', ['Ganjil', 'Genap'])->nullable(false);
            $table->date('tanggal_mulai')->nullable(true); //Akan false saat prod
            $table->date('tanggal_selesai')->nullable(true); //Akan false saat prod
            $table->enum('status', ['Aktif', 'Non-Aktif', 'Aktif-Khusus'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
