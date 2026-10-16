<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'ip_address',
        'user_agent',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record an audit log entry.
     */
    public static function record(
        string $action,
        string $description,
        ?Model $subject = null,
        ?string $userName = null,
        ?string $ipAddress = null
    ): self {
        $user = auth()->user();
        $request = request();

        return static::create([
            'user_id' => $user?->id,
            'user_name' => $userName ?: ($user?->name ?: 'Admin Perpustakaan'),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? class_basename($subject) : null,
            'subject_id' => $subject?->getKey(),
            'ip_address' => $ipAddress ?: ($request?->ip() ?: '127.0.0.1'),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
