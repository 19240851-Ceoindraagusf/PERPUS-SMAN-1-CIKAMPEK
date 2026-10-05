<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('access_logs', function (Blueprint $table) {
            $table->string('action', 20)->default('view')->after('ebook_id');
            $table->string('visitor_hash', 64)->nullable()->after('ip_address');
            $table->index(['ebook_id', 'action', 'visitor_hash', 'accessed_at'], 'access_logs_unique_activity_lookup');
            $table->index(['action', 'accessed_at'], 'access_logs_action_date_lookup');
        });
    }

    public function down(): void
    {
        Schema::table('access_logs', function (Blueprint $table) {
            $table->dropIndex('access_logs_unique_activity_lookup');
            $table->dropIndex('access_logs_action_date_lookup');
            $table->dropColumn(['action', 'visitor_hash']);
        });
    }
};
