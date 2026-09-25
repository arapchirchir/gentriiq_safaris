<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * Exposes a non-guessable `uuid` column in URLs instead of the sequential id.
 *
 * The integer `id` stays the primary key; `uuid` (time-ordered UUIDv7) is generated on create
 * and used for implicit route binding. Malformed values resolve to a 404 rather than a query.
 * Routes that bind by another field explicitly (e.g. {tour:slug}) are unaffected.
 */
trait HasPublicUuid
{
    use HasUuids;

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
