<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_academic_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nim', 8)->nullable(false);
            $table->char('laporan_id', 20)->nullable(false);
            $table->integer('semester')->nullable(true);
            $table->string('activity_name', 255)->nullable(true);
            $table->text('strategy')->nullable(true);
            $table->enum('status', ['Draft', 'Pending', 'Valid', 'Rejected'])->default('Draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_academic_activities');
    }
};
