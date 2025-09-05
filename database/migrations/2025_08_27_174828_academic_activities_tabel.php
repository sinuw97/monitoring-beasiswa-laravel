<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->char('nim', 8)->nullable(false);
            $table->char('laporan_id', 20)->nullable(false);
            $table->integer('semester')->nullable(true);
            $table->string('activity_name', 255)->nullable(true);
            $table->string('activity_type', 255)->nullable(true);
            $table->string('participation', 100)->nullable(true);
            $table->string('place', 255)->nullable(true);
            $table->date('start_date')->nullable(true);
            $table->date('end_date')->nullable(true);
            $table->text('bukti_url')->nullable(true);
            $table->integer('points')->nullable(true);
            $table->text('comment')->nullable(true);
            $table->enum('status', ['Draft', 'Pending', 'Valid', 'Rejected'])->default('Draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_activities');
    }
};
