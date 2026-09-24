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
                'summary' => 'Track lions, leopards, elephants, rhinos, and Cape buffaloes in their natural East African habitat.',
                'icon' => 'eye',
                'featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Honeymoon Tours',
                'slug' => 'honeymoon-safaris',
                'summary' => 'Intimate luxury tented camps, private bush dinners under the African stars, and romantic sunset game drives.',
                'icon' => 'heart',
                'featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Family Safaris',
                'slug' => 'family-safaris',
                'summary' => 'Engaging wildlife education, child-friendly lodges with pools, and safe private guided game drives.',
                'icon' => 'users',
                'featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Photography Tours',
                'slug' => 'photography-safaris',
                'summary' => 'Custom vehicles with beanbag camera mounts, dedicated low-angle doors, and guides trained in lighting and animal behavior.',
                'icon' => 'camera',
                'featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Cultural Visits',
                'slug' => 'cultural-tours',
                'summary' => 'Authentic interactions with Maasai and Samburu communities, visiting bomas and learning ancestral traditions.',
                'icon' => 'globe',
                'featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Bush to Beach',
                'slug' => 'bush-to-beach',
                'summary' => 'The ultimate journey combining thrilling safari savannahs with peaceful Indian Ocean coastal retreats.',
                'icon' => 'sun',
                'featured' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::updateOrCreate(['slug' => $experience['slug']], $experience);
        }
    }
}
