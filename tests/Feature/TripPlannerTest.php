<?php

use App\Models\Destination;
use App\Models\Experience;
use App\Models\Inquiry;
use App\Models\Tour;

function plannerExperience(string $name = 'Big Five Safaris', bool $inPlanner = true): Experience
{
    return Experience::create(['name' => $name, 'show_in_planner' => $inPlanner]);
}

test('trip planner questionnaire page loads successfully with 6 steps', function () {
    $response = $this->get(route('plan.create'));

    $response->assertOk()
        ->assertSee('What kind of trip are you dreaming of?')
        ->assertSee('Who will you be traveling with?')
        ->assertSee('When would you like to travel?')
        ->assertSee('Select Travel Date')
        ->assertSee('Dates within the next 10 days are unavailable.')
        ->assertSee('Tour Duration')
        ->assertSee('Accommodation Style')
        ->assertSee('Where should we send your custom safari plan?')
        ->assertSee('Safari Plan Preview')
        ->assertSee('Get my plan')
        ->assertSee('Takes about 2 minutes');
});

test('trip planner validates required fields on submission', function () {
    $response = $this->post(route('plan.store'), []);

    $response->assertSessionHasErrors([
        'experiences',
        'traveller_type',
        'adults_count',
        'travel_year',
        'travel_month',
        'travel_date',
        'duration',
        'name',
        'email',
    ]);
});

test('trip planner stores inquiry in database and redirects to unique plan url', function () {
    $safari = plannerExperience();

    $payload = [
        'experiences' => [$safari->id],
        'traveller_type' => 'partner',
        'adults_count' => 2,
        'children_count' => 0,
        'travel_year' => '2026',
        'travel_month' => 'October',
        'travel_date' => '2026-10-15',
        'travel_season' => 'High Season',
        'duration' => '7-9_days',
        'accommodation_tier' => 'luxury',
        'name' => 'Sarah Connor',
        'email' => 'sarah@example.com',
        'phone' => '+1 555 987 6543',
        'country' => 'United States',
        'special_requests' => 'Interested in seeing tree-climbing lions and balloon safari over Serengeti.',
    ];

    $response = $this->post(route('plan.store'), $payload);

    $inquiry = Inquiry::where('email', 'sarah@example.com')->first();
    expect($inquiry)->not->toBeNull()
        ->and($inquiry->name)->toBe('Sarah Connor')
        ->and($inquiry->experiences->pluck('id')->all())->toBe([$safari->id])
        ->and($inquiry->travel_month)->toBe('October')
        ->and($inquiry->token)->not->toBeEmpty()
        ->and($inquiry->reference)->toStartWith('GS-');

    $response->assertRedirect(route('plan.show', ['token' => $inquiry->token]));
    $response->assertSessionHas('success');
});

test('trip planner preserves package and destination context', function () {
    $tour = Tour::create([
        'title' => 'Context Safari',
        'duration_days' => 3,
        'duration_nights' => 2,
        'starting_price' => 900,
        'status' => 'published',
        'published_at' => now(),
    ]);
    $destination = Destination::create(['name' => 'Context Destination', 'country' => 'Kenya']);

    $payload = [
        'tour_id' => $tour->id,
        'destination_id' => $destination->id,
        'experiences' => [plannerExperience()->id],
        'traveller_type' => 'partner',
        'adults_count' => 2,
        'travel_year' => '2027',
        'travel_month' => 'June',
        'travel_date' => '2027-06-15',
        'duration' => '2-3_days',
        'name' => 'Context Guest',
        'email' => 'context@example.com',
    ];

    $this->post(route('plan.store'), $payload)->assertSessionHas('success');

    $inquiry = Inquiry::where('email', 'context@example.com')->firstOrFail();

    expect($inquiry->tour_id)->toBe($tour->id)
        ->and($inquiry->destination_id)->toBe($destination->id)
        ->and($inquiry->whatsapp_message)->toContain('Package: Context Safari')
        ->and($inquiry->whatsapp_message)->toContain('Destination: Context Destination');
});

test('trip planner allows multiple experiences in step 1 and links them to the inquiry', function () {
    $safari = plannerExperience('Big Five Safaris');
    $beach = plannerExperience('Beach Holidays');

    $payload = [
        'experiences' => [$safari->id, $beach->id],
        'traveller_type' => 'partner',
        'adults_count' => 2,
        'children_count' => 0,
        'travel_year' => '2026',
        'travel_month' => 'October',
        'travel_date' => '2026-10-15',
        'travel_season' => 'High Season',
        'duration' => '7-9_days',
        'accommodation_tier' => 'luxury',
        'name' => 'Alexander Smith',
        'email' => 'alex@example.com',
    ];

    $response = $this->post(route('plan.store'), $payload);

    $inquiry = Inquiry::where('email', 'alex@example.com')->first();
    expect($inquiry)->not->toBeNull()
        ->and($inquiry->experiences)->toHaveCount(2)
        ->and($inquiry->experiences_label)->toContain('Big Five Safaris')
        ->and($inquiry->experiences_label)->toContain('Beach Holidays');

    $response->assertRedirect(route('plan.show', ['token' => $inquiry->token]));
});

test('unique plan page renders saved inquiry data and primary whatsapp link', function () {
    $inquiry = Inquiry::create([
        'traveller_type' => 'family',
        'adults_count' => 2,
        'children_count' => 2,
        'travel_year' => '2027',
        'travel_month' => 'August',
        'travel_date' => '2027-08-15',
        'travel_season' => 'Peak Season (Great Migration)',
        'duration' => '7-9_days',
        'accommodation_tier' => 'signature_luxury',
        'name' => 'David Livingstone',
        'email' => 'david@safari.org',
        'phone' => '+44 20 7946 0919',
        'country' => 'United Kingdom',
        'special_requests' => 'Family suite requested with connecting rooms.',
        'budget_range' => '4000_7000',
        'status' => 'new',
    ]);
    $inquiry->experiences()->attach(plannerExperience('Big Five Safaris'));

    $response = $this->get(route('plan.show', ['token' => $inquiry->token]));

    $response->assertOk()
        ->assertSee($inquiry->reference)
        ->assertSee('David Livingstone')
        ->assertSee('Big Five Safaris')
        ->assertSee('$4,000 – $7,000 per person')
        ->assertSee('Aug 15, 2027')
        ->assertSee('Peak Season (Great Migration)')
        ->assertSee('7 to 9 Days')
        ->assertSee('Ultra-Luxury')
        ->assertSee('Family suite requested with connecting rooms')
        ->assertSee('https://wa.me/254717838061', false)
        ->assertSee($inquiry->share_url, false)
        ->assertSee('+254 717 838061');

    expect($inquiry->whatsapp_message)->toContain('Booking Ref: '.$inquiry->reference)
        ->and($inquiry->whatsapp_message)->toContain('Experiences: Big Five Safaris')
        ->and($inquiry->whatsapp_message)->toContain('Budget: $4,000 – $7,000 per person')
        ->and($inquiry->whatsapp_message)->not->toContain('🌍')
        ->and($inquiry->whatsapp_message)->not->toContain('🦁')
        ->and($inquiry->whatsapp_message)->not->toContain('📋')
        ->and($inquiry->whatsapp_message)->not->toContain('🔗');
});

test('trip planner rejects travel dates within the ten day planning window', function () {
    $payload = [
        'experiences' => [plannerExperience()->id],
        'traveller_type' => 'partner',
        'adults_count' => 2,
        'travel_year' => now()->year,
        'travel_month' => now()->format('F'),
        'travel_date' => now()->addDays(9)->toDateString(),
        'duration' => '7-9_days',
        'name' => 'Short Notice Guest',
        'email' => 'short-notice@example.com',
    ];

    $this->post(route('plan.store'), $payload)
        ->assertSessionHasErrors('travel_date');
});

test('invalid token returns 404 not found', function () {
    $response = $this->get(route('plan.show', ['token' => 'invalid-uuid-token']));

    $response->assertNotFound();
});

test('trip planner lists only experiences switched on for the planner', function () {
    plannerExperience('Big Five Safaris');
    plannerExperience('Retired Balloon Package', inPlanner: false);

    $response = $this->get(route('plan.create'))
        ->assertOk()
        ->assertSee('Big Five Safaris')
        ->assertDontSee('Retired Balloon Package')
        ->assertSee('With Partner');

    // Whitespace-insensitive: the Blade formatter may wrap card copy across lines.
    expect(preg_replace('/\s+/', ' ', $response->getContent()))->toContain('Couples, honeymoons and anniversaries.');
});

test('trip planner rejects experiences that are hidden from the planner or invalid budgets', function () {
    $hidden = plannerExperience('Hidden Experience', inPlanner: false);

    $this->post(route('plan.store'), [
        'experiences' => [$hidden->id],
        'budget_range' => 'millionaire',
    ])->assertSessionHasErrors(['experiences.0', 'budget_range']);
});

test('arriving from a tour pre-selects its planner experiences', function () {
    $safari = plannerExperience('Big Five Safaris');
    $tour = Tour::create([
        'title' => 'Mara Explorer',
        'duration_days' => 3,
        'duration_nights' => 2,
        'starting_price' => 900,
        'status' => 'published',
        'published_at' => now(),
    ]);
    $tour->experiences()->attach($safari);

    $this->get(route('plan.create', ['tour' => $tour->slug]))
        ->assertOk()
        ->assertViewHas('selectedExperienceIds', [$safari->id]);
});

test('trip planner first paint matches its initial state before alpine loads', function () {
    plannerExperience('Big Five Safaris');

    $html = $this->get(route('plan.create'))->assertOk()->getContent();

    // Later steps and step-dependent buttons stay hidden until Alpine initialises.
    foreach (range(2, 6) as $step) {
        expect($html)->toContain('x-show="step === '.$step.'" x-cloak');
    }

    // Selection styling is CSS-driven (data-selected), never JS-only x-show/:class that flash while loading.
    expect($html)->not->toContain('x-show="isExperienceSelected')
        ->and($html)->toContain(':data-selected="isExperienceSelected(')
        ->and($html)->toContain('Step 1 out of 6');
});
