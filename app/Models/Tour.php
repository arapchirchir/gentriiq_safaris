<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'duration_days',
        'duration_nights',
        'starting_price',
        'currency',
        'tour_type',
        'difficulty',
        'badge',
        'country',
        'location_summary',
        'hero_image',
        'gallery',
        'highlights',
        'inclusions',
        'exclusions',
        'featured',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'duration_days' => 'integer',
            'duration_nights' => 'integer',
            'starting_price' => 'decimal:2',
            'featured' => 'boolean',
            'gallery' => 'array',
            'highlights' => 'array',
            'inclusions' => 'array',
            'exclusions' => 'array',
            'published_at' => 'datetime',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Tour $tour): void {
            if (blank($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });
    }

    public function days(): HasMany
    {
        return $this->hasMany(TourDay::class)->orderBy('day_number');
    }

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'tour_destination');
    }

    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class, 'tour_experience');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true)->orderBy('sort_order');
    }

    public function getFormattedPriceAttribute(): string
    {
        $symbol = match ($this->currency) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'KES' => 'KES ',
            default => $this->currency . ' ',
        };

        return $symbol . number_format((float) $this->starting_price, 0);
    }
}
