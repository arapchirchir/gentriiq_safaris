<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Backfill photos for the seeded experiences; never overwrites an image already set.
     */
    public const IMAGES = [
        'big-five-safaris' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=800&q=80',
        'honeymoon-safaris' => 'https://images.unsplash.com/photo-1564760055775-d63b17a55c44?auto=format&fit=crop&w=800&q=80',
        'family-safaris' => 'https://images.unsplash.com/photo-1521651201144-634f700b36ef?auto=format&fit=crop&w=800&q=80',
        'photography-safaris' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?auto=format&fit=crop&w=800&q=80',
        'cultural-tours' => 'https://images.unsplash.com/photo-1743540039517-4616029166fb?auto=format&fit=crop&w=800&q=80',
        'bush-to-beach' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
    ];

    public function up(): void
    {
        foreach (self::IMAGES as $slug => $image) {
            DB::table('experiences')->where('slug', $slug)->whereNull('image')->update(['image' => $image]);
        }
    }

    public function down(): void
    {
        foreach (self::IMAGES as $slug => $image) {
            DB::table('experiences')->where('slug', $slug)->where('image', $image)->update(['image' => null]);
        }
    }
};
