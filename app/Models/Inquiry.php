<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Inquiry extends Model
{
    use HasFactory;

    /**
     * Optional per-person budget brackets offered in the trip planner (USD, excluding international flights).
     */
    public const BUDGET_RANGES = [
        'under_2000' => 'Under $2,000',
        '2000_4000' => '$2,000 – $4,000',
        '4000_7000' => '$4,000 – $7,000',
        '7000_plus' => '$7,000+',
    ];

    protected $fillable = [
        'reference',
        'token',
        'tour_id',
        'destination_id',
        'traveller_type',
        'adults_count',
        'children_count',
        'travel_year',
        'travel_month',
        'travel_date',
        'travel_season',
        'duration',
        'accommodation_tier',
        'budget_range',
        'name',
        'email',
        'phone',
        'whatsapp',
        'country',
        'special_requests',
        'status',
        'ip_address',
        'user_agent',
    ];

    // internal_notes is intentionally absent from $fillable — only assigned explicitly in staff controllers.

    protected function casts(): array
    {
        return [
            'adults_count' => 'integer',
            'children_count' => 'integer',
            'travel_date' => 'date',
        ];
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Inquiry $inquiry) {
            if (empty($inquiry->token)) {
                $inquiry->token = (string) Str::uuid();
            }
            if (empty($inquiry->reference)) {
                $inquiry->reference = 'GS-'.strtoupper(Str::random(6));
            }
        });
    }

    public function getExperiencesLabelAttribute(): string
    {
        $names = $this->experiences->pluck('name');

        return $names->isNotEmpty() ? $names->implode(' + ') : 'Custom Safari';
    }

    public function getBudgetLabelAttribute(): ?string
    {
        return self::BUDGET_RANGES[$this->budget_range] ?? null;
    }

    public function getTravellerLabelAttribute(): string
    {
        $base = match ($this->traveller_type) {
            'solo' => 'Solo Traveler',
            'partner' => 'Couple / Partner',
            'family' => 'Family Holiday',
            'group' => 'Private Group of Friends',
            default => ucfirst($this->traveller_type),
        };

        $counts = "{$this->adults_count} ".Str::plural('Adult', $this->adults_count);
        if ($this->children_count > 0) {
            $counts .= ", {$this->children_count} ".Str::plural('Child', $this->children_count);
        }

        return "{$base} ({$counts})";
    }

    public function getDurationLabelAttribute(): string
    {
        return match ($this->duration) {
            '2-3_days' => '2 to 3 Days (Short Safari Getaway)',
            '4-6_days' => '4 to 6 Days (East Africa Highlights)',
            '7-9_days' => '7 to 9 Days (Classic Safari Experience)',
            '10plus_days' => '10+ Days (Grand Wildlife Expedition)',
            default => $this->duration,
        };
    }

    public function getAccommodationLabelAttribute(): string
    {
        return match ($this->accommodation_tier) {
            'comfort' => 'Comfort / Mid-range Lodges & Tented Camps',
            'luxury' => 'Luxury Safari Lodges & Camps',
            'signature_luxury' => 'Ultra-Luxury / Exclusive Boutique Camps',
            default => 'Not specified / Flexible',
        };
    }

    public function getShareUrlAttribute(): string
    {
        return route('plan.show', ['token' => $this->token]);
    }

    public function getWhatsAppMessageAttribute(): string
    {
        $text = "Hello Gentriiq Safaris & Tours!\n";
        $text .= "I have customized a safari plan on your website.\n\n";
        $text .= "Booking Ref: {$this->reference}\n";
        $text .= 'View Full Plan: '.$this->share_url."\n\n";
        if ($this->tour) {
            $text .= "- Package: {$this->tour->title}\n";
        }
        if ($this->destination) {
            $text .= "- Destination: {$this->destination->name}\n";
        }
        $text .= '- Experiences: '.$this->experiences_label."\n";
        $text .= '- Travelers: '.$this->traveller_label."\n";
        $travelDate = $this->travel_date
            ? Carbon::parse((string) $this->travel_date)->format('M d, Y')
            : "{$this->travel_month} {$this->travel_year}";
        $text .= "- Travel Date: {$travelDate}".($this->travel_season ? " ({$this->travel_season})" : '')."\n";
        $text .= '- Duration: '.$this->duration_label."\n";
        $text .= '- Accommodation: '.$this->accommodation_label."\n";
        if ($this->budget_label) {
            $text .= '- Budget: '.$this->budget_label." per person\n";
        }
        $text .= "- Lead Guest: {$this->name}".($this->country ? " ({$this->country})" : '')."\n";
        $text .= "- Email: {$this->email}\n";
        if ($this->whatsapp || $this->phone) {
            $text .= '- Phone: '.($this->whatsapp ?: $this->phone)."\n";
        }
        if ($this->special_requests) {
            $text .= '- Safari Wishlist: '.Str::limit($this->special_requests, 100)."\n";
        }
        $text .= "\nPlease share a personalized itinerary and quote. Thank you!";

        return $text;
    }

    public function getWhatsAppUrlAttribute(): string
    {
        return 'https://wa.me/254717838061?text='.urlencode($this->whatsapp_message);
    }
}
