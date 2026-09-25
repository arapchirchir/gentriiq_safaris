<?php

use App\Models\Destination;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function tourFormPayload(array $overrides = []): array
{
    return array_replace([
        'title' => 'Seven Day Safari',
        'duration_days' => 7,
        'duration_nights' => 6,
        'starting_price' => '1850.25',
        'tour_type' => 'private',
        'status' => 'draft',
    ], $overrides);
}

test('draft packages accept incomplete content and keep defaults compatible with storage', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('admin.tours.store'), tourFormPayload([
        'days' => [['title' => 'Arrival'], ['title' => null]], 'difficulty' => null, 'country' => null,
    ]))->assertSessionHasNoErrors()->assertRedirect();

    $tour = Tour::sole();
    expect($tour->status)->toBe('draft')->and($tour->days)->toHaveCount(2)
        ->and($tour->difficulty)->toBe('easy')->and($tour->country)->toBe('Kenya')
        ->and($tour->formatted_price)->toBe('$1,850.25');
});

test('package validation rejects inconsistent data without saving a tour', function (array $input, string $field) {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('admin.tours.store'), tourFormPayload($input))
        ->assertSessionHasErrors($field);

    expect(Tour::count())->toBe(0);
})->with([
    'too many days' => [['days' => array_fill(0, 8, ['title' => 'Drive'])], 'days'],
    'nights exceed days' => [['duration_nights' => 8], 'duration_nights'],
    'nights equal days' => [['duration_nights' => 7], 'duration_nights'],
    'fractional days' => [['duration_days' => 7.5], 'duration_days'],
    'price exceeds storage' => [['starting_price' => '100000000'], 'starting_price'],
    'excess price precision' => [['starting_price' => '1850.255'], 'starting_price'],
    'invalid destination' => [['destinations' => [99999]], 'destinations.0'],
    'invalid experience' => [['experiences' => [99999]], 'experiences.0'],
    'malformed days' => [['days' => 'invalid'], 'days'],
    'nonsequential array keys' => [['days' => [3 => ['title' => 'Drive']]], 'days'],
    'long image url' => [['hero_image' => 'https://example.com/'.str_repeat('a', 240)], 'hero_image'],
    'invalid currency' => [['currency' => 'XXX'], 'currency'],
]);

test('publishing requires a complete meaningful package', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('admin.tours.store'), tourFormPayload([
        'status' => 'published', 'description' => '<p>&nbsp;</p>', 'starting_price' => 0,
    ]))->assertSessionHasErrors(['days', 'destinations', 'description', 'short_description', 'hero_image', 'starting_price']);

    expect(Tour::count())->toBe(0);
});

test('published itinerary requires titles and descriptions for each day', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('admin.tours.store'), tourFormPayload([
        'status' => 'published', 'days' => array_fill(0, 7, ['title' => '', 'description' => '']),
    ]))->assertSessionHasErrors(['days.0.title', 'days.0.description', 'days.6.title']);
});

test('published packages derive countries and normalize itinerary numbering', function () {
    $user = User::factory()->create();
    $kenya = Destination::create(['name' => 'Mara', 'country' => 'Kenya']);
    $tanzania = Destination::create(['name' => 'Serengeti', 'country' => 'Tanzania']);

    $this->actingAs($user)->post(route('admin.tours.store'), tourFormPayload([
        'status' => 'published', 'short_description' => 'Explore East Africa.',
        'description' => '<p>Wildlife across two countries.</p>', 'hero_image' => 'https://images.unsplash.com/test.jpg',
        'destinations' => [$tanzania->id, $kenya->id], 'country' => 'Wrong country',
        'days' => array_fill(0, 7, ['day_number' => 99, 'title' => 'Wildlife drive', 'description' => 'Explore the park.']),
        'meta_title' => 'Custom safari title', 'meta_description' => 'Custom safari description',
    ]))->assertSessionHasNoErrors()->assertRedirect();

    $tour = Tour::sole();
    expect($tour->country)->toBe('Kenya, Tanzania')->and($tour->published_at)->not->toBeNull()
        ->and($tour->days->pluck('day_number')->all())->toBe([1, 2, 3, 4, 5, 6, 7])
        ->and($tour->destinations)->toHaveCount(2);
    $this->get(route('tours.show', $tour))->assertOk()->assertSee('Custom safari title')->assertSee('Custom safari description');
});

test('failed validation preserves explicitly cleared selections and lists', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post(route('admin.tours.store'), tourFormPayload(['title' => '']))
        ->assertSessionHasErrors('title')->assertSessionHasInput('destinations', [])
        ->assertSessionHasInput('experiences', [])->assertSessionHasInput('days', [])
        ->assertSessionHasInput('highlights', [])->assertSessionHasInput('featured', false);
});

test('saving an edited package preserves retained day records and removes omitted data', function () {
    $user = User::factory()->create();
    $tour = Tour::create(tourFormPayload());
    $day = $tour->days()->create(['day_number' => 1, 'title' => 'Arrival']);
    $tour->days()->create(['day_number' => 2, 'title' => 'Departure']);
    $destination = Destination::create(['name' => 'Mara']);
    $tour->destinations()->attach($destination);

    $this->actingAs($user)->put(route('admin.tours.update', $tour), tourFormPayload([
        'days' => [['title' => 'Updated arrival']],
    ]))->assertSessionHasNoErrors()->assertRedirect(route('admin.tours.edit', $tour));

    expect($tour->fresh()->days->sole()->id)->toBe($day->id)
        ->and($day->fresh()->title)->toBe('Updated arrival')
        ->and($tour->fresh()->destinations)->toHaveCount(0);
});

test('a failed itinerary write rolls back package and relationship changes', function () {
    $user = User::factory()->create();
    $tour = Tour::create(tourFormPayload());
    $day = $tour->days()->create(['day_number' => 1, 'title' => 'Original day']);
    $destination = Destination::create(['name' => 'Mara']);
    $tour->destinations()->attach($destination);
    DB::statement("CREATE TRIGGER reject_day_update BEFORE UPDATE ON tour_days BEGIN SELECT RAISE(ABORT, 'Simulated write failure'); END");

    try {
        $this->actingAs($user)->put(route('admin.tours.update', $tour), tourFormPayload([
            'title' => 'Changed title', 'days' => [['title' => 'Changed day']],
        ]))->assertStatus(500);

        expect($tour->fresh()->title)->toBe('Seven Day Safari')
            ->and($day->fresh()->title)->toBe('Original day')
            ->and($tour->fresh()->destinations->modelKeys())->toBe([$destination->id]);
    } finally {
        DB::statement('DROP TRIGGER reject_day_update');
    }
});

test('duplicate package and destination names receive distinct slugs', function () {
    $first = Tour::create(tourFormPayload());
    $second = Tour::create(tourFormPayload());
    $destination = Destination::create(['name' => 'Mara']);
    $other = Destination::create(['name' => 'Mara']);

    expect($second->slug)->not->toBe($first->slug)
        ->and($other->slug)->not->toBe($destination->slug);
});

test('sales staff cannot save package changes', function () {
    $user = User::factory()->create(['role' => User::ROLE_SALES]);

    $this->actingAs($user)->post(route('admin.tours.store'), tourFormPayload())->assertForbidden();
    expect(Tour::count())->toBe(0);
});

test('package create and edit pages render', function () {
    $user = User::factory()->create();
    $tour = Tour::create(tourFormPayload());

    $this->actingAs($user)->get(route('admin.tours.create'))->assertOk()->assertSee('Add Day');
    $this->get(route('admin.tours.edit', $tour))->assertOk()->assertSee('Save Changes');
});
