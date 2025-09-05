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
        Schema::table('academic_reports', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('academic_activities', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('committee_activities', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('organization_activities', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('student_achievements', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('independent_activities', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('evaluations', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('target_next_semester', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('target_academic_activities', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('target_achievements', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });

        Schema::table('target_independent_activities', function (Blueprint $table) {
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('laporan_id')->references('laporan_id')->on('laporan_mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
