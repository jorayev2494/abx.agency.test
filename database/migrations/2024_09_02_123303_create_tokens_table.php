<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tokens', static function (Blueprint $table): void {
            $table->uuid()->primary();

            $table->string('user_agent')->nullable();
            $table->string('ip', 20)->nullable();
            $table->string('location', 255)->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
