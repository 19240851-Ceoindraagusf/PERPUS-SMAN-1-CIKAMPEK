<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ebook_comment_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ebook_comment_id')->constrained()->cascadeOnDelete();
            $table->string('reason', 30);
            $table->string('status', 20)->default('open');
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebook_comment_reports');
    }
};
