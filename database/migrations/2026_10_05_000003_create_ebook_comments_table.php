<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ebook_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ebook_id')->constrained()->cascadeOnDelete();
            $table->string('display_name', 80);
            $table->text('message');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            $table->index(['ebook_id', 'is_approved', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebook_comments');
    }
};
