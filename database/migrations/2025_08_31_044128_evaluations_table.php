<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nim', 8)->nullable(false);
            $table->char('laporan_id', 20)->nullable(false);
            $table->integer('semester')->nullable(true);
            $table->text('support_factors')->nullable(true);
            $table->text('barrier_factors')->nullable(true);
            $table->enum('status', ['Draft', 'Pending', 'Valid', 'Rejected'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
