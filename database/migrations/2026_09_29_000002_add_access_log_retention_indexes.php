<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('access_logs', function (Blueprint $table) {
            $table->index('accessed_at');
            $table->index(['ebook_id', 'accessed_at']);
        });
    }

    public function down(): void
    {
        Schema::table('access_logs', function (Blueprint $table) {
            $table->dropIndex(['accessed_at']);
            $table->dropIndex(['ebook_id', 'accessed_at']);
        });
    }
};
