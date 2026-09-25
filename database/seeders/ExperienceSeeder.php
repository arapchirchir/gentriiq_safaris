<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $experiences = [
            [
                'name' => 'Big Five Safaris',
                'slug' => 'big-five-safaris',
                'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?auto=format&fit=crop&w=800&q=80',
                'summary' => 'Track lions, leopards, elephants, rhinos, and Cape buffaloes in their natural East African habitat.',
                'icon' => 'eye',
                'featured' => true,
                'show_in_planner' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Honeymoon Tours',
                'slug' => 'honeymoon-safaris',
                'image' => 'https://images.unsplash.com/photo-1564760055775-d63b17a55c44?auto=format&fit=crop&w=800&q=80',
                'summary' => 'Intimate luxury tented camps, private bush dinners under the African stars, and romantic sunset game drives.',
                'icon' => 'heart',
                'featured' => true,
                'show_in_planner' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Family Safaris',
                'slug' => 'family-safaris',
                'image' => 'https://images.unsplash.com/photo-1521651201144-634f700b36ef?auto=format&fit=crop&w=800&q=80',
                'summary' => 'Engaging wildlife education, child-friendly lodges with pools, and safe private guided game drives.',
                'icon' => 'users',
                'featured' => true,
                'show_in_planner' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Photography Tours',
                'slug' => 'photography-safaris',
                'image' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?auto=format&fit=crop&w=800&q=80',
                'summary' => 'Custom vehicles with beanbag camera mounts, dedicated low-angle doors, and guides trained in lighting and animal behavior.',
                'icon' => 'camera',
                'featured' => true,
                'show_in_planner' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Cultural Visits',
                'slug' => 'cultural-tours',
                'image' => 'https://images.unsplash.com/photo-1743540039517-4616029166fb?auto=format&fit=crop&w=800&q=80',
                'summary' => 'Authentic interactions with Maasai and Samburu communities, visiting bomas and learning ancestral traditions.',
                'icon' => 'globe',
                'featured' => true,
                'show_in_planner' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Bush to Beach',
                'slug' => 'bush-to-beach',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'summary' => 'The ultimate journey combining thrilling safari savannahs with peaceful Indian Ocean coastal retreats.',
                'icon' => 'sun',
                'featured' => true,
                'show_in_planner' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Mountain Trekking',
                'slug' => 'mountain-trekking',
                'image' => 'https://images.unsplash.com/photo-1621414050946-1b936a78491f?auto=format&fit=crop&w=800&q=80',
                'summary' => 'Guided Kilimanjaro and Mount Kenya climbs with experienced mountain crews.',
                'featured' => false,
                'show_in_planner' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Beach Holidays',
                'slug' => 'beach-holidays',
                'image' => 'https://images.unsplash.com/photo-1607444807093-eefb769187da?auto=format&fit=crop&w=800&q=80',
                'summary' => 'Relaxed white-sand stays on Diani Beach and Zanzibar.',
                'featured' => false,
                'show_in_planner' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::updateOrCreate(['slug' => $experience['slug']], $experience);
        }
    }
}
