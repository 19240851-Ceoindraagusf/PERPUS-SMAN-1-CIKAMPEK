<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbookCommentReport extends Model
{
    use HasFactory;

    protected $fillable = ['ebook_comment_id', 'reason', 'status'];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(EbookComment::class, 'ebook_comment_id');
    }
}
