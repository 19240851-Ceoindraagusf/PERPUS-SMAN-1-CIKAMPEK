<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbookComment extends Model
{
    use HasFactory;

    protected $fillable = ['ebook_id', 'display_name', 'message', 'rating', 'is_approved', 'seen_by_admin_at'];

    protected $casts = ['is_approved' => 'boolean', 'seen_by_admin_at' => 'datetime'];

    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class);
    }

    public function reports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EbookCommentReport::class);
    }
}
