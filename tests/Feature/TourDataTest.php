<?php

use App\Models\Destination;
use App\Models\Experience;
use App\Models\Tour;
use Database\Seeders\DatabaseSeeder;

test('database seeder populates tours, destinations, and experiences', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Tour::count())->toBeGreaterThanOrEqual(6)
        ->and(Destination::count())->toBeGreaterThanOrEqual(6)
        ->and(Experience::count())->toBeGreaterThanOrEqual(6);
});

test('homepage displays published featured tours from the database', function () {
    $tour = Tour::create([
        'title' => 'Serengeti Migration Adventure',
        'slug' => 'serengeti-migration-adventure',
        'short_description' => 'Unforgettable wildlife tracking.',
        'duration_days' => 6,
        'duration_nights' => 5,
        'starting_price' => 2200.00,
        'currency' => 'USD',
        'tour_type' => 'private',
        'difficulty' => 'easy',
        'country' => 'Tanzania',
        'featured' => true,
        'status' => 'published',
        'published_at' => now()->subDay(),
        'hero_image' => 'https://example.com/tour.jpg',
    ]);

    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('Serengeti Migration Adventure')
        ->assertSee('$2,200');
});

test('homepage ignores draft tours', function () {
    $draftTour = Tour::create([
        'title' => 'Secret Unpublished Expedition',
        'slug' => 'secret-unpublished-expedition',
        'short_description' => 'Draft description.',
        'duration_days' => 3,
        'duration_nights' => 2,
        'starting_price' => 999.00,
        'currency' => 'USD',
        'featured' => true,
        'status' => 'draft',
        'published_at' => null,
    ]);

    $response = $this->get('/');

    $response->assertOk()
        ->assertDontSee('Secret Unpublished Expedition');
});

test('tours relate to destinations and tour days', function () {
    $destination = Destination::create([
        'name' => 'Maasai Mara',
        'slug' => 'maasai-mara-test',
        'country' => 'Kenya',
    ]);

    $tour = Tour::create([
        'title' => 'Mara Explorer Test',
        'slug' => 'mara-explorer-test',
        'duration_days' => 2,
        'duration_nights' => 1,
        'starting_price' => 600.00,
        'status' => 'published',
        'published_at' => now(),
    ]);

    $tour->destinations()->attach($destination);
    $tour->days()->create([
        'day_number' => 1,
        'title' => 'Arrival & Sunset Drive',
        'location' => 'Maasai Mara',
    ]);

    expect($tour->destinations->first()->name)->toBe('Maasai Mara')
        ->and($tour->days->first()->title)->toBe('Arrival & Sunset Drive');
});

test('published tours and destinations have public detail pages', function () {
    $this->seed(DatabaseSeeder::class);

    $tour = Tour::where('slug', '7-day-kenya-classic-explorer')->firstOrFail();
    $destination = Destination::where('slug', 'diani-zanzibar')->firstOrFail();

    $this->get(route('tours.show', $tour))
        ->assertOk()
        ->assertSee($tour->title)
        ->assertSee('Detailed itinerary');

    $this->get(route('destinations.show', $destination))
        ->assertOk()
        ->assertSee($destination->name)
        ->assertSee('Packages featuring');
});

test('draft tours cannot be viewed publicly', function () {
    $tour = Tour::create([
        'title' => 'Draft Detail Test',
        'duration_days' => 2,
        'duration_nights' => 1,
        'starting_price' => 500,
        'status' => 'draft',
    ]);

    $this->get(route('tours.show', $tour))->assertNotFound();
});

test('tour and destination slugs are generated from names when omitted', function () {
    $tour = Tour::create([
        'title' => 'Kenya & Tanzania Highlights',
        'duration_days' => 4,
        'duration_nights' => 3,
        'starting_price' => 1200,
        'status' => 'draft',
    ]);
    $destination = Destination::create(['name' => 'Lake Turkana', 'country' => 'Kenya']);

    expect($tour->slug)->toBe('kenya-tanzania-highlights')
        ->and($destination->slug)->toBe('lake-turkana');
});
