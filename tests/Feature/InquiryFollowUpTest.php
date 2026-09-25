<?php

use App\Models\Inquiry;
use App\Models\InquiryUpdate;
use App\Models\User;

function followUpInquiry(): Inquiry
{
    return Inquiry::create([
        'traveller_type' => 'partner',
        'adults_count' => 2,
        'travel_year' => '2026',
        'travel_month' => 'December',
        'travel_date' => '2026-12-09',
        'duration' => '4-6_days',
        'name' => 'Dennis Kipchumba',
        'email' => 'guest@example.com',
        'status' => 'new',
    ]);
}

test('several staff members build one shared follow-up history with their names', function () {
    $jane = User::factory()->create(['name' => 'Jane Wanjiru', 'role' => User::ROLE_SALES]);
    $peter = User::factory()->create(['name' => 'Peter Otieno', 'role' => User::ROLE_SALES]);
    $inquiry = followUpInquiry();

    $this->actingAs($jane)->put(route('admin.inquiries.update', $inquiry), ['status' => 'new', 'note' => 'Did not pick up the call.'])
        ->assertSessionHas('success');
    $this->actingAs($peter)->put(route('admin.inquiries.update', $inquiry), ['status' => 'new', 'note' => 'Called later, will get back to us.']);
    $this->actingAs($jane)->put(route('admin.inquiries.update', $inquiry), ['status' => 'contacted', 'note' => 'Wants Mara + Diani options.']);

    expect($inquiry->refresh()->status)->toBe('contacted')
        ->and($inquiry->updates)->toHaveCount(3);

    $latest = $inquiry->updates->first();
    expect($latest->author_name)->toBe('Jane Wanjiru')
        ->and($latest->author_role)->toBe('Safari Sales Specialist')
        ->and($latest->previous_status)->toBe('new')
        ->and($latest->status)->toBe('contacted');

    $this->actingAs($peter)->get(route('admin.inquiries.show', $inquiry))
        ->assertOk()
        ->assertSeeInOrder([
            'Follow-up History',
            'Wants Mara + Diani options.', 'Jane Wanjiru',
            'Called later, will get back to us.', 'Peter Otieno',
            'Did not pick up the call.', 'Jane Wanjiru',
            'Inquiry Status & Operations',
        ]);
});

test('a status change without a note is recorded, but an empty update is rejected', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);
    $inquiry = followUpInquiry();

    $this->actingAs($sales)->put(route('admin.inquiries.update', $inquiry), ['status' => 'new', 'note' => '   '])
        ->assertSessionHasErrors('note');
    expect($inquiry->updates()->count())->toBe(0);

    $this->actingAs($sales)->put(route('admin.inquiries.update', $inquiry), ['status' => 'quote_sent']);
    $update = $inquiry->updates()->first();
    expect($update->note)->toBeNull()
        ->and($update->isStatusChange())->toBeTrue();
});

test('the author cannot be spoofed from the form', function () {
    $sales = User::factory()->create(['name' => 'Real Person', 'role' => User::ROLE_SALES]);
    $inquiry = followUpInquiry();

    $this->actingAs($sales)->put(route('admin.inquiries.update', $inquiry), [
        'status' => 'contacted',
        'note' => 'Hello',
        'author_name' => 'The Director',
        'user_id' => 999,
    ]);

    expect($inquiry->updates()->first()->author_name)->toBe('Real Person')
        ->and($inquiry->updates()->first()->user_id)->toBe($sales->id);
});

test('history keeps the author name after the staff account is deleted', function () {
    $sales = User::factory()->create(['name' => 'Former Colleague', 'role' => User::ROLE_SALES]);
    $inquiry = followUpInquiry();
    $this->actingAs($sales)->put(route('admin.inquiries.update', $inquiry), ['status' => 'new', 'note' => 'Left a voicemail.']);

    $sales->delete();

    $update = InquiryUpdate::first();
    expect($update->user_id)->toBeNull()
        ->and($update->author_name)->toBe('Former Colleague');
});

test('follow-up notes are never shown to the guest or editors', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);
    $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);
    $inquiry = followUpInquiry();
    $this->actingAs($sales)->put(route('admin.inquiries.update', $inquiry), ['status' => 'contacted', 'note' => 'Guest budget is tight, offer comfort tier.']);

    auth()->logout();
    $this->get(route('plan.show', ['token' => $inquiry->token]))
        ->assertOk()
        ->assertDontSee('Guest budget is tight');

    $this->actingAs($editor)->put(route('admin.inquiries.update', $inquiry), ['status' => 'confirmed', 'note' => 'x'])
        ->assertForbidden();
});

test('invalid statuses are rejected', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);

    $this->actingAs($sales)->put(route('admin.inquiries.update', followUpInquiry()), ['status' => 'paid_in_full', 'note' => 'x'])
        ->assertSessionHasErrors('status');
});

test('the inquiry page does not display the private plan token or the guest ip address', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);
    $inquiry = followUpInquiry();
    $inquiry->forceFill(['ip_address' => '102.0.29.92'])->save();

    $html = $this->actingAs($sales)->get(route('admin.inquiries.show', $inquiry))->assertOk()->getContent();

    // The token may only appear inside the "View Guest Proposal Page" link, never as visible text.
    expect(substr_count($html, $inquiry->token))->toBe(1)
        ->and($html)->toContain('href="'.route('plan.show', ['token' => $inquiry->token]).'"')
        ->and($html)->not->toContain('102.0.29.92')
        ->and($html)->not->toContain('Audit Information');
});

test('staff inquiry urls use the uuid, not the numeric id or the guest token', function () {
    $sales = User::factory()->create(['role' => User::ROLE_SALES]);
    $inquiry = followUpInquiry();

    expect($inquiry->uuid)->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/')
        ->and($inquiry->uuid)->not->toBe($inquiry->token)
        ->and(route('admin.inquiries.show', $inquiry))->toEndWith('/staff/inquiries/'.$inquiry->uuid);

    $this->actingAs($sales)->get('/staff/inquiries/'.$inquiry->uuid)->assertOk();
    $this->actingAs($sales)->get('/staff/inquiries/'.$inquiry->id)->assertNotFound();
    $this->actingAs($sales)->get('/staff/inquiries/'.$inquiry->token)->assertNotFound();

    $this->actingAs($sales)->get(route('admin.inquiries.index'))
        ->assertSee(route('admin.inquiries.show', $inquiry), false)
        ->assertDontSee('/staff/inquiries/'.$inquiry->id.'"', false);
});
