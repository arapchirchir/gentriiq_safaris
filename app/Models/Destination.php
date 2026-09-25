<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'country',
        'featured_badge',
        'summary',
        'description',
        'image',
        'featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Destination $destination): void {
            if (blank($destination->slug)) {
                $base = Str::limit(Str::slug($destination->name), 220, '') ?: 'destination';
                $destination->slug = $base;
                while (static::where('slug', $destination->slug)->exists()) {
                    $destination->slug = $base.'-'.Str::lower(Str::random(8));
                }
            }
        });
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_destination');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true)->orderBy('sort_order');
    }
}
