<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_mahasiswa', function (Blueprint $table) {
            $table->char('nim', 8)->primary();
            $table->string('prodi')->nullable(false);
            $table->string('angkatan')->nullable(false);
            $table->string('kelas')->nullable(false);
            $table->string('jenis_beasiswa', 100);
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('no_hp')->nullable(true);
            $table->string('alamat')->nullable(true);
            $table->enum('status', ['Aktif', 'Non-Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_mahasiswa');
    }
};
