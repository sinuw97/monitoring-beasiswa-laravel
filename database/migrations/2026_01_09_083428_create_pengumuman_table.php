<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('pengumuman')) {
            Schema::table('pengumuman', function (Blueprint $table) {
                if (!Schema::hasColumn('pengumuman', 'created_at')) {
                    $table->timestamps();
                }
            });
        } else {
            Schema::create('pengumuman', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->text('isi');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
