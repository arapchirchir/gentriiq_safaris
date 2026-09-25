<?php

namespace App\Models;

use App\Models\Concerns\HasPublicUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Experience extends Model
{
    use HasFactory, HasPublicUuid;

    protected $fillable = [
        'name',
        'slug',
        'summary',
        'icon',
        'image',
        'featured',
        'show_in_planner',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'show_in_planner' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Experience $experience): void {
            if (blank($experience->slug)) {
                $base = Str::limit(Str::slug($experience->name), 220, '') ?: 'experience';
                $experience->slug = $base;
                while (static::where('slug', $experience->slug)->exists()) {
                    $experience->slug = $base.'-'.Str::lower(Str::random(8));
                }
            }
        });
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_experience');
    }

    public function inquiries(): BelongsToMany
    {
        return $this->belongsToMany(Inquiry::class);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true)->orderBy('sort_order');
    }

    public function scopeInPlanner(Builder $query): Builder
    {
        return $query->where('show_in_planner', true)->orderBy('sort_order')->orderBy('name');
    }
}
