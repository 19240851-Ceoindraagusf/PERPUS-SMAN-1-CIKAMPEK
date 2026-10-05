<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EbookReport extends Model
{
    use HasFactory;

    protected $fillable = ['ebook_id', 'reporter_name', 'category', 'message', 'status'];

    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class);
    }
}
