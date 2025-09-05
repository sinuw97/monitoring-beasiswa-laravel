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
        Schema::create('google_tokens', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 8);
            $table->string('access_token')->nullable(false);
            $table->string('refresh_token')->nullable(false);
            $table->string('scope')->nullable(false);
            $table->string('expire_date')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('google_tokens');
    }
};
