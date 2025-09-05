<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_achievements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nim', 8)->nullable(false);
            $table->char('laporan_id', 20)->nullable(false);
            $table->integer('semester')->nullable(true);
            $table->string('achievements_name', 255)->nullable(true);
            $table->string('level', 100)->nullable(true);
            $table->string('award', 100)->nullable(true);
            $table->enum('status', ['Draft', 'Pending', 'Valid', 'Rejected'])->default('Draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_achievements');
    }
};
