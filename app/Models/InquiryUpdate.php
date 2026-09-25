<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One entry in an inquiry's follow-up history. Entries are append-only: never edited or deleted.
 */
class InquiryUpdate extends Model
{
    // Every attribute is set explicitly by the staff controller from the authenticated user.
    protected $guarded = ['*'];

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return Inquiry::STATUSES[$this->status]['short'] ?? ucfirst(str_replace('_', ' ', $this->status));
    }

    public function isStatusChange(): bool
    {
        return $this->previous_status !== null && $this->previous_status !== $this->status;
    }
}
