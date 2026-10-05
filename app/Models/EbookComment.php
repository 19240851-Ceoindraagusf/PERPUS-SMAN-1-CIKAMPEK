<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbookComment extends Model
{
    use HasFactory;

    protected $fillable = ['ebook_id', 'display_name', 'message', 'is_approved'];

    protected $casts = ['is_approved' => 'boolean'];

    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class);
    }
}
