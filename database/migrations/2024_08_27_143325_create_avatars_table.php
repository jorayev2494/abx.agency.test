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
        Schema::create('avatars', static function (Blueprint $table): void {
            $table->uuid()->primary();

            $table->foreignUuid('owner_uuid')->references('uuid')->on('users')->onDelete('RESTRICT');
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('path');
            $table->string('mime_type');
            $table->string('type');
            $table->string('extension');
            $table->integer('size');
            $table->string('file_name')->nullable();
            $table->string('file_original_name');
            $table->string('name');
            $table->string('full_path');
            $table->string('url');
            $table->string('url_pattern');
            $table->integer('downloaded_count')->default(0);
            $table->string('disk');
            $table->boolean('is_public')->default(false);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
