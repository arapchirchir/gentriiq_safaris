<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Maasai Mara Reserve',
                'slug' => 'maasai-mara',
                'country' => 'Kenya',
                'featured_badge' => 'Kenya • World Wonder',
                'summary' => 'The crown jewel of African wildlife sanctuaries, famed for the Great Wildebeest Migration and high predator densities.',
                'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80',
                'featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Amboseli National Park',
                'slug' => 'amboseli',
                'country' => 'Kenya',
                'featured_badge' => 'Kenya • Mountain Backdrop',
                'summary' => 'Celebrated for giant herds of free-ranging African elephants against the majestic snows of Mount Kilimanjaro.',
                'image' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?auto=format&fit=crop&w=800&q=80',
                'featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Serengeti & Ngorongoro',
                'slug' => 'serengeti-ngorongoro',
                'country' => 'Tanzania',
                'featured_badge' => 'Tanzania • Endless Plains',
                'summary' => 'Endless horizons of savannah teeming with wildebeest, lions, cheetahs, and the world\'s largest unbroken volcanic caldera.',
                'image' => 'https://images.unsplash.com/photo-1549366021-9f761d450615?auto=format&fit=crop&w=800&q=80',
                'featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Samburu Reserve',
                'slug' => 'samburu',
                'country' => 'Kenya',
                'featured_badge' => 'Northern Kenya • Arid Beauty',
                'summary' => 'A rugged, dramatic wilderness renowned for the Samburu Special Five and the rich pastoral culture of the Samburu people.',
                'image' => 'https://images.unsplash.com/photo-1575550959106-5a7defe28b56?auto=format&fit=crop&w=800&q=80',
                'featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Lake Nakuru & Naivasha',
                'slug' => 'lake-nakuru-naivasha',
                'country' => 'Kenya',
                'featured_badge' => 'Rift Valley • Lakes & Rhinos',
                'summary' => 'Sanctuary for endangered black and white rhinos, boat safaris among pods of hippos, and walking safaris on Crescent Island.',
                'image' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=800&q=80',
                'featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Diani & Zanzibar',
                'slug' => 'diani-zanzibar',
                'country' => 'Kenya',
                'featured_badge' => 'Swahili Coast • Turquoise Ocean',
                'summary' => 'Powder-white beaches, coral reefs, and tranquil Indian Ocean breezes — the dream coastal extension after exhilarating bush adventures.',
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'featured' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::updateOrCreate(['slug' => $destination['slug']], $destination);
        }
    }
}
