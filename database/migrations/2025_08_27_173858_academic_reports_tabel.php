<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_reports', function (Blueprint $table){
            $table->uuid('id')->primary();
            $table->char('nim', 20)->nullable(false);
            $table->char('laporan_id', 36)->nullable(false);
            $table->integer('semester')->nullable(true);
            $table->decimal('ips', 3, 2)->nullable(true);
            $table->decimal('ipk', 3, 2)->nullable(true);
            $table->text('comment')->nullable(true);
            $table->text('bukti_url')->nullable(true);
            $table->enum('status', ['Draft','Pending','Valid','Rejected','Revisi'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_reports');
    }
};
