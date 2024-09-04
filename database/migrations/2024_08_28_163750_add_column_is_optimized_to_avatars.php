<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const COLUMN_NAME = 'is_optimized';

    public function up(): void
    {
        Schema::table('avatars', static function (Blueprint $table): void {
            $table->boolean(self::COLUMN_NAME)->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('avatars', static function (Blueprint $table): void {
            $table->removeColumn(self::COLUMN_NAME);
        });
    }
};
