<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ebook_comments', function (Blueprint $table) {
            $table->timestamp('seen_by_admin_at')->nullable()->after('is_approved');
            $table->index('seen_by_admin_at');
        });
    }

    public function down(): void
    {
        Schema::table('ebook_comments', function (Blueprint $table) {
            $table->dropIndex(['seen_by_admin_at']);
            $table->dropColumn('seen_by_admin_at');
        });
    }
};
