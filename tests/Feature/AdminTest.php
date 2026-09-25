<?php

use App\Models\Destination;
use App\Models\Experience;
use App\Models\Inquiry;
use App\Models\Tour;
use App\Models\User;

test('unauthenticated visitors are redirected from admin area to login', function () {
    $this->get('/staff')->assertRedirect(route('login'));
    $this->get(route('admin.inquiries.index'))->assertRedirect(route('login'));
    $this->get(route('admin.tours.index'))->assertRedirect(route('login'));
});

test('super admin has full access to dashboard, inquiries, and tours', function () {
    $superAdmin = User::factory()->create([
        'role' => User::ROLE_SUPER_ADMIN,
        'is_active' => true,
    ]);

    $this->actingAs($superAdmin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Dashboard Overview')
        ->assertSee($superAdmin->name);

    $this->actingAs($superAdmin)
        ->get(route('admin.inquiries.index'))
        ->assertOk()
        ->assertSee('Safari plans');

    $this->actingAs($superAdmin)
        ->get(route('admin.tours.index'))
        ->assertOk()
        ->assertSee('Tours & Safari Packages');
});

test('sales user can manage inquiries but is forbidden from tour editing', function () {
    $salesUser = User::factory()->create([
        'role' => User::ROLE_SALES,
        'is_active' => true,
    ]);

    $this->actingAs($salesUser)
        ->get(route('admin.dashboard'))
        ->assertOk();

    $this->actingAs($salesUser)
        ->get(route('admin.inquiries.index'))
        ->assertOk();

    $this->actingAs($salesUser)
        ->get(route('admin.tours.index'))
        ->assertForbidden();
});

test('content editor can manage tours but is forbidden from customer inquiries', function () {
    $editorUser = User::factory()->create([
        'role' => User::ROLE_EDITOR,
        'is_active' => true,
    ]);

    $this->actingAs($editorUser)
        ->get(route('admin.dashboard'))
        ->assertOk();

    $this->actingAs($editorUser)
        ->get(route('admin.tours.index'))
        ->assertOk();

    $this->actingAs($editorUser)
        ->get(route('admin.inquiries.index'))
        ->assertForbidden();
});

test('inactive staff users are rejected with forbidden error', function () {
    $inactiveUser = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'is_active' => false,
    ]);

    $this->actingAs($inactiveUser)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('editor can update tour details and published status', function () {
    $editor = User::factory()->create([
        'role' => User::ROLE_EDITOR,
        'is_active' => true,
    ]);

    $tour = Tour::create([
        'title' => 'Test Safari Expedition',
        'slug' => 'test-safari-expedition',
        'short_description' => 'A wonderful safari trip',
        'description' => 'Detailed itinerary description goes here.',
        'duration_days' => 5,
        'duration_nights' => 4,
        'starting_price' => 1500,
        'currency' => 'USD',
        'tour_type' => 'private',
        'status' => 'draft',
    ]);

    $this->actingAs($editor)
        ->get(route('admin.tours.edit', $tour))
        ->assertOk()
        ->assertSee('Edit Safari Package')
        ->assertSee('Test Safari Expedition');

    $destination = Destination::create(['name' => 'Mara', 'country' => 'Kenya']);

    $response = $this->actingAs($editor)
        ->put(route('admin.tours.update', $tour), [
            'title' => 'Updated Safari Expedition',
            'short_description' => 'An updated wonderful safari trip',
            'description' => 'Updated detailed itinerary description.',
            'duration_days' => 5,
            'duration_nights' => 4,
            'hero_image' => 'https://images.unsplash.com/safari.jpg',
            'destinations' => [$destination->id],
            'days' => array_fill(0, 5, ['title' => 'Game drive', 'description' => 'Explore the reserve.']),
            'starting_price' => 1800,
            'tour_type' => 'both',
            'status' => 'published',
            'featured' => 1,
        ]);

    $response->assertRedirect(route('admin.tours.edit', $tour))
        ->assertSessionHas('success');

    $tour->refresh();
    expect($tour->title)->toBe('Updated Safari Expedition')
        ->and($tour->starting_price)->toBe('1800.00')
        ->and($tour->status)->toBe('published')
        ->and($tour->featured)->toBeTrue()
        ->and($tour->published_at)->not->toBeNull();
});

test('destination image URLs cannot break out of the alpine expression', function () {
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR, 'is_active' => true]);
    $payload = "https://x.com/a?b=');alert(document.cookie);('";

    $destination = Destination::create([
        'name' => 'Amboseli',
        'country' => 'Kenya',
        'summary' => 'Elephants below Kilimanjaro.',
        'image' => $payload,
    ]);

    $this->actingAs($editor)
        ->get(route('admin.destinations.edit', $destination))
        ->assertOk()
        // Raw quotes never reach the page; inside the Alpine script the link is JS-encoded.
        // (In plain value="" / src="" attributes it is HTML-escaped as &#039;, which is safe there.)
        ->assertDontSee("');alert(", false)
        ->assertSee("link: 'https:\\/\\/x.com\\/a?b=\\u0027);alert(document.cookie);(\\u0027'", false);

    $this->actingAs($editor)
        ->from(route('admin.destinations.create'))
        ->post(route('admin.destinations.store'), ['image' => $payload]);

    $this->actingAs($editor)
        ->get(route('admin.destinations.create'))
        ->assertOk()
        // Raw quotes never reach the page; inside the Alpine script the link is JS-encoded.
        // (In plain value="" / src="" attributes it is HTML-escaped as &#039;, which is safe there.)
        ->assertDontSee("');alert(", false)
        ->assertSee("link: 'https:\\/\\/x.com\\/a?b=\\u0027);alert(document.cookie);(\\u0027'", false);
});

test('staff navigation only shows the sections each role can open', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);

    $this->actingAs($sales)->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('href="'.route('admin.inquiries.index').'"', false)
        ->assertDontSee('href="'.route('admin.tours.index').'"', false)
        ->assertDontSee('href="'.route('admin.experiences.index').'"', false);

    $this->actingAs($editor)->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('href="'.route('admin.tours.index').'"', false)
        ->assertSee('href="'.route('admin.destinations.index').'"', false)
        ->assertDontSee('href="'.route('admin.inquiries.index').'"', false);
});

test('editors do not see guest inquiry details on the dashboard', function () {
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);
    Inquiry::create([
        'traveller_type' => 'solo', 'adults_count' => 1, 'travel_year' => '2027', 'travel_month' => 'March',
        'travel_date' => '2027-03-01', 'duration' => '4-6_days', 'name' => 'Private Guest', 'email' => 'private.guest@example.com',
    ]);

    $this->actingAs($editor)->get(route('admin.dashboard'))
        ->assertOk()
        ->assertDontSee('Private Guest')
        ->assertDontSee('private.guest@example.com')
        ->assertDontSee('View All Inquiries');
});

test('admin catalogue urls use uuids while public pages keep readable slugs', function () {
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);
    $tour = Tour::create(['title' => 'Uuid Safari', 'duration_days' => 2, 'duration_nights' => 1, 'starting_price' => 500, 'status' => 'published', 'published_at' => now()->subDay()]);
    $destination = Destination::create(['name' => 'Uuid Mara', 'country' => 'Kenya']);
    $experience = Experience::create(['name' => 'Uuid Balloon']);

    foreach ([
        [route('admin.tours.edit', $tour), $tour],
        [route('admin.destinations.edit', $destination), $destination],
        [route('admin.experiences.edit', $experience), $experience],
    ] as [$url, $model]) {
        expect($url)->toContain('/'.$model->uuid.'/edit')->not->toContain('/'.$model->id.'/edit');
        $this->actingAs($editor)->get($url)->assertOk();
        $this->actingAs($editor)->get(str_replace($model->uuid, (string) $model->id, $url))->assertNotFound();
    }

    expect(route('tours.show', $tour))->toEndWith('/tours/uuid-safari')
        ->and(route('destinations.show', $destination))->toEndWith('/destinations/uuid-mara');
    $this->get(route('tours.show', $tour))->assertOk();
});
