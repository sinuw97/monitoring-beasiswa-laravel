<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organization_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nim', 20)->nullable(false);
            $table->char('laporan_id', 36)->nullable(false);
            $table->string('ukm_name', 100)->nullable(true);
            $table->string('activity_name', 255)->nullable(true);
            $table->string('level', 100)->default('Perguruan Tinggi');
            $table->string('position', 100)->nullable(true);
            $table->string('place', 255)->nullable(true);
            $table->date('start_date')->nullable(true);
            $table->date('end_date')->nullable(true);
            $table->text('bukti_url')->nullable(true);
            $table->integer('points')->nullable(true);
            $table->text('comment')->nullable(true);
            $table->enum('status', ['Draft','Pending','Valid','Rejected','Revisi'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_activities');
    }
};
