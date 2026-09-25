<?php

use App\Actions\SavePhoto;
use App\Models\Destination;
use App\Models\Experience;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->editor = User::factory()->create(['role' => User::ROLE_EDITOR]);
});

function storedFile(?string $value): string
{
    return str($value)->after('/storage/')->toString();
}

function tourPayload(array $overrides = []): array
{
    $destination = Destination::create(['name' => 'Mara '.uniqid(), 'country' => 'Kenya']);

    return array_merge([
        'title' => 'Photo Safari',
        'short_description' => 'A safari with our own photos.',
        'description' => 'Full itinerary description.',
        'duration_days' => 2,
        'duration_nights' => 1,
        'starting_price' => 1200,
        'tour_type' => 'private',
        'status' => 'published',
        'destinations' => [$destination->id],
        'days' => array_fill(0, 2, ['title' => 'Game drive', 'description' => 'Explore the reserve.']),
    ], $overrides);
}

test('an uploaded photo is resized, converted to webp and stored under a random name', function () {
    $this->actingAs($this->editor)->post(route('admin.experiences.store'), [
        'name' => 'Balloon Safaris',
        'image_upload' => UploadedFile::fake()->image('IMG_2041.jpg', 4000, 3000),
    ])->assertSessionHasNoErrors();

    $image = Experience::firstWhere('name', 'Balloon Safaris')->image;

    expect(SavePhoto::isUploaded($image))->toBeTrue()
        ->and($image)->not->toContain('IMG_2041');
    Storage::disk('public')->assertExists(storedFile($image));

    $info = getimagesizefromstring(Storage::disk('public')->get(storedFile($image)));
    expect($info['mime'])->toBe('image/webp')
        ->and($info[0])->toBe(2000)
        ->and($info[1])->toBe(1500);
});

test('svg files and non-images disguised as photos are rejected', function (UploadedFile $file) {
    $this->actingAs($this->editor)->post(route('admin.experiences.store'), [
        'name' => 'Sneaky',
        'image_upload' => $file,
    ])->assertSessionHasErrors('image_upload');

    expect(Experience::where('name', 'Sneaky')->exists())->toBeFalse();
    expect(Storage::disk('public')->allFiles())->toBeEmpty();
})->with([
    'svg' => fn () => UploadedFile::fake()->createWithContent('logo.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'),
    'php disguised as jpg' => fn () => UploadedFile::fake()->createWithContent('shell.php.jpg', '<?php system($_GET["c"]); ?>'),
    'pdf' => fn () => UploadedFile::fake()->create('brochure.pdf', 100, 'application/pdf'),
]);

test('the photo field only accepts http links or our own uploaded paths', function (string $value) {
    $this->actingAs($this->editor)->post(route('admin.destinations.store'), [
        'name' => 'Tampered',
        'country' => 'Kenya',
        'summary' => 'Test',
        'image' => $value,
    ])->assertSessionHasErrors('image');
})->with([
    'javascript url' => 'javascript:alert(1)',
    'path traversal' => '/storage/uploads/destinations/../../../.env',
    'other server path' => '/etc/passwd',
    'non-uuid upload name' => '/storage/uploads/destinations/shell.php',
]);

test('links still work alongside uploads', function () {
    $this->actingAs($this->editor)->post(route('admin.destinations.store'), [
        'name' => 'Linked',
        'country' => 'Kenya',
        'summary' => 'Test',
        'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801',
    ])->assertSessionHasNoErrors();

    expect(Destination::firstWhere('name', 'Linked')->image)->toBe('https://images.unsplash.com/photo-1516426122078-c23e76319801');
});

test('replacing, keeping and deleting photos manages the stored files', function () {
    $this->actingAs($this->editor)->post(route('admin.destinations.store'), [
        'name' => 'Amboseli',
        'country' => 'Kenya',
        'summary' => 'Elephants.',
        'image_upload' => UploadedFile::fake()->image('first.jpg', 800, 600),
    ]);
    $destination = Destination::firstWhere('name', 'Amboseli');
    $first = $destination->image;

    // Saving again without a new file keeps the existing upload.
    $this->actingAs($this->editor)->put(route('admin.destinations.update', $destination), [
        'name' => 'Amboseli', 'country' => 'Kenya', 'summary' => 'Elephants.', 'image' => $first,
    ])->assertSessionHasNoErrors();
    expect($destination->refresh()->image)->toBe($first);
    Storage::disk('public')->assertExists(storedFile($first));

    // A new upload replaces the old file.
    $this->actingAs($this->editor)->put(route('admin.destinations.update', $destination), [
        'name' => 'Amboseli', 'country' => 'Kenya', 'summary' => 'Elephants.', 'image' => $first,
        'image_upload' => UploadedFile::fake()->image('second.png', 800, 600),
    ])->assertSessionHasNoErrors();
    $second = $destination->refresh()->image;
    expect($second)->not->toBe($first);
    Storage::disk('public')->assertMissing(storedFile($first));
    Storage::disk('public')->assertExists(storedFile($second));

    // Deleting the destination removes its photo.
    $this->actingAs($this->editor)->delete(route('admin.destinations.destroy', $destination));
    Storage::disk('public')->assertMissing(storedFile($second));
});

test('a published tour accepts an uploaded hero photo instead of a link', function () {
    $this->actingAs($this->editor)
        ->post(route('admin.tours.store'), tourPayload(['hero_image_upload' => UploadedFile::fake()->image('hero.jpg', 1600, 900)]))
        ->assertSessionHasNoErrors();

    $tour = Tour::firstWhere('title', 'Photo Safari');
    expect(SavePhoto::isUploaded($tour->hero_image))->toBeTrue();

    $this->get(route('tours.show', $tour))
        ->assertOk()
        ->assertSee('<meta property="og:image" content="'.url($tour->hero_image).'">', false);
});

test('a published tour still requires a hero photo from either source', function () {
    $this->actingAs($this->editor)
        ->post(route('admin.tours.store'), tourPayload())
        ->assertSessionHasErrors('hero_image');
});
