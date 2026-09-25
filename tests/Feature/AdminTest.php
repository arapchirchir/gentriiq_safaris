<?php

use App\Models\Destination;
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

test('sales specialist can update inquiry status and internal notes', function () {
    $salesUser = User::factory()->create([
        'role' => User::ROLE_SALES,
        'is_active' => true,
    ]);

    $inquiry = Inquiry::create([
        'traveller_type' => 'partner',
        'adults_count' => 2,
        'children_count' => 0,
        'travel_year' => '2026',
        'travel_month' => 'October',
        'travel_date' => '2026-10-15',
        'duration' => '7-9_days',
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'phone' => '+254712345678',
        'status' => 'new',
    ]);

    $this->actingAs($salesUser)
        ->get(route('admin.inquiries.show', $inquiry))
        ->assertOk()
        ->assertSee('Jane Smith')
        ->assertSee('Dossier');

    $response = $this->actingAs($salesUser)
        ->put(route('admin.inquiries.update', $inquiry), [
            'status' => 'contacted',
            'internal_notes' => 'Called Jane, she is interested in Mara luxury camps.',
        ]);

    $response->assertSessionHas('success');

    $inquiry->refresh();
    expect($inquiry->status)->toBe('contacted')
        ->and($inquiry->internal_notes)->toBe('Called Jane, she is interested in Mara luxury camps.');
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
