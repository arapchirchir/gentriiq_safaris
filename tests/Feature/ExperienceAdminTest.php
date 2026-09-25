<?php

use App\Models\Experience;
use App\Models\Inquiry;
use App\Models\Tour;
use App\Models\User;

function inquiryFor(array $experiences, array $attributes = []): Inquiry
{
    $inquiry = Inquiry::create(array_merge([
        'traveller_type' => 'partner',
        'adults_count' => 2,
        'children_count' => 1,
        'travel_year' => '2027',
        'travel_month' => 'July',
        'travel_date' => '2027-07-10',
        'duration' => '7-9_days',
        'name' => 'Quote Guest',
        'email' => 'quote@example.com',
    ], $attributes));
    $inquiry->experiences()->attach(collect($experiences)->pluck('id')->all());

    return $inquiry;
}

function publishedTour(string $title, float $price, array $experiences = []): Tour
{
    $tour = Tour::create([
        'title' => $title,
        'duration_days' => 5,
        'duration_nights' => 4,
        'starting_price' => $price,
        'status' => 'published',
        'published_at' => now()->subDay(),
    ]);
    $tour->experiences()->attach(collect($experiences)->pluck('id')->all());

    return $tour;
}

test('editors can create and update experiences with planner visibility', function () {
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);

    $this->actingAs($editor)->post(route('admin.experiences.store'), [
        'name' => 'Gorilla Trekking',
        'summary' => 'Meet mountain gorillas in Rwanda and Uganda.',
        'image' => 'https://images.unsplash.com/photo-123',
        'show_in_planner' => '1',
    ])->assertRedirect();

    $experience = Experience::where('slug', 'gorilla-trekking')->firstOrFail();
    expect($experience->show_in_planner)->toBeTrue()
        ->and($experience->featured)->toBeFalse();

    $this->actingAs($editor)->put(route('admin.experiences.update', $experience), [
        'name' => 'Gorilla Trekking',
        'featured' => '1',
    ])->assertRedirect(route('admin.experiences.edit', $experience));

    expect($experience->refresh()->featured)->toBeTrue()
        ->and($experience->show_in_planner)->toBeFalse();
});

test('sales staff cannot manage experiences', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);

    $this->actingAs($sales)->get(route('admin.experiences.index'))->assertForbidden();
    $this->actingAs($sales)->post(route('admin.experiences.store'), ['name' => 'Nope'])->assertForbidden();
});

test('experience image URLs must be http links and cannot break out of the preview script', function () {
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);

    $this->actingAs($editor)->post(route('admin.experiences.store'), [
        'name' => 'Bad Link',
        'image' => 'javascript:alert(1)',
    ])->assertSessionHasErrors('image');

    $experience = Experience::create(['name' => 'Quoted', 'image' => "https://x.com/a?b=');alert(1);('"]);

    $this->actingAs($editor)->get(route('admin.experiences.edit', $experience))
        ->assertOk()
        ->assertDontSee("');alert(", false);
});

test('an experience chosen on inquiries cannot be deleted, an unused one can', function () {
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);
    $used = Experience::create(['name' => 'Used Experience', 'show_in_planner' => true]);
    $unused = Experience::create(['name' => 'Unused Experience']);
    inquiryFor([$used]);

    $this->actingAs($editor)->delete(route('admin.experiences.destroy', $used))
        ->assertSessionHasErrors('experience');
    $this->assertModelExists($used);

    $this->actingAs($editor)->delete(route('admin.experiences.destroy', $unused))
        ->assertRedirect(route('admin.experiences.index'));
    $this->assertModelMissing($unused);
});

test('inquiry page gives staff experiences, budget, price estimate and matching packages for quoting', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);
    $bigFive = Experience::create(['name' => 'Big Five Safaris', 'show_in_planner' => true]);
    $beach = Experience::create(['name' => 'Beach Holidays', 'show_in_planner' => true]);

    $origin = publishedTour('Mara Classic', 1500, [$bigFive]);
    publishedTour('Bush and Beach Combo', 2400, [$bigFive, $beach]);
    publishedTour('Unrelated City Tour', 300);

    $inquiry = inquiryFor([$bigFive, $beach], ['tour_id' => $origin->id, 'budget_range' => '2000_4000']);

    $this->actingAs($sales)->get(route('admin.inquiries.show', $inquiry))
        ->assertOk()
        ->assertSee('Big Five Safaris')
        ->assertSee('Beach Holidays')
        ->assertSee('$2,000 – $4,000')
        // 2 adults + 1 child at the $1,500 starting price.
        ->assertSee('$4,500')
        ->assertSeeInOrder(['Matching Packages', 'Bush and Beach Combo', 'Matches 2 of 2 experiences'])
        ->assertDontSee('Unrelated City Tour');
});
