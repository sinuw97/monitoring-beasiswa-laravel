<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_mahasiswa', function (Blueprint $table) {
            $table->char('laporan_id', 20)->primary();
            $table->char('nim', 8)->nullable(false);
            $table->char('semester_id', 8)->nullable(false);
            $table->enum('status', ['Pending', 'Lolos', 'Draft', 'Ditolak SP-1', 'Ditolak SP-2', 'Ditolak SP-3', 'Lolos dengan penugasan'])->default('Draft');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('laporan_mahasiswa');
    }
};
