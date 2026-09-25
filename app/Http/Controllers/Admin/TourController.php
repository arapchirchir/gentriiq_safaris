<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SavePhoto;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveTourRequest;
use App\Models\Destination;
use App\Models\Experience;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $query = Tour::query()->with(['destinations', 'experiences', 'days'])->latest();

        if ($status && in_array($status, ['published', 'draft', 'archived'], true)) {
            $query->where('status', $status);
        }

        $tours = $query->paginate(12)->withQueryString();

        $counts = [
            'all' => Tour::count(),
            'published' => Tour::where('status', 'published')->count(),
            'draft' => Tour::where('status', 'draft')->count(),
            'archived' => Tour::where('status', 'archived')->count(),
        ];

        return view('admin.tours.index', compact('tours', 'counts', 'status'));
    }

    public function create(): View
    {
        $destinations = Destination::orderBy('name')->get();
        $experiences = Experience::orderBy('name')->get();

        return view('admin.tours.create', compact('destinations', 'experiences'));
    }

    public function store(SaveTourRequest $request, SavePhoto $photos): RedirectResponse
    {
        $validated = $request->validated();
        $validated['hero_image'] = $photos->resolve($request->file('hero_image_upload'), $validated['hero_image'] ?? null, 'tours');

        $tour = DB::transaction(function () use ($validated, $request): Tour {
            $tour = Tour::create($this->coreFields($validated, $request));
            $this->saveRelations($tour, $validated);

            return $tour;
        });

        return redirect()->route('admin.tours.edit', $tour)
            ->with('success', "Tour '{$tour->title}' created successfully.");
    }

    public function edit(Tour $tour): View
    {
        $tour->load(['days', 'destinations', 'experiences']);
        $destinations = Destination::orderBy('name')->get();
        $experiences = Experience::orderBy('name')->get();

        return view('admin.tours.edit', compact('tour', 'destinations', 'experiences'));
    }

    public function update(SaveTourRequest $request, Tour $tour, SavePhoto $photos): RedirectResponse
    {
        $validated = $request->validated();
        $validated['hero_image'] = $photos->resolve($request->file('hero_image_upload'), $validated['hero_image'] ?? null, 'tours');
        $previousImage = $tour->hero_image;

        DB::transaction(function () use ($tour, $validated, $request): void {
            $tour->update($this->coreFields($validated, $request));
            $this->saveRelations($tour, $validated);
        });
        $photos->discard($previousImage, $tour->hero_image);

        return redirect()->route('admin.tours.edit', $tour)
            ->with('success', "Tour '{$tour->title}' updated successfully.");
    }

    public function destroy(Tour $tour, SavePhoto $photos): RedirectResponse
    {
        $title = $tour->title;
        $tour->delete();
        $photos->discard($tour->hero_image);

        return redirect()->route('admin.tours.index')
            ->with('success', "Tour '{$title}' deleted.");
    }

    private function coreFields(array $validated, Request $request): array
    {
        return [
            'title' => $validated['title'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'duration_days' => $validated['duration_days'],
            'duration_nights' => $validated['duration_nights'],
            'starting_price' => $validated['starting_price'],
            'currency' => $validated['currency'] ?? 'USD',
            'tour_type' => $validated['tour_type'],
            'difficulty' => $validated['difficulty'] ?? 'easy',
            'badge' => $validated['badge'] ?? null,
            'country' => $validated['country'] ?? 'Kenya',
            'location_summary' => $validated['location_summary'] ?? null,
            'hero_image' => $validated['hero_image'] ?? null,
            'status' => $validated['status'],
            'featured' => $request->boolean('featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'highlights' => array_values(array_filter($validated['highlights'] ?? [], fn ($v) => trim((string) $v) !== '')),
            'inclusions' => array_values(array_filter($validated['inclusions'] ?? [], fn ($v) => trim((string) $v) !== '')),
            'exclusions' => array_values(array_filter($validated['exclusions'] ?? [], fn ($v) => trim((string) $v) !== '')),
        ];
    }

    private function saveRelations(Tour $tour, array $validated): void
    {
        $tour->destinations()->sync($validated['destinations']);
        $tour->experiences()->sync($validated['experiences']);

        $countries = $tour->destinations()->orderBy('country')->pluck('country')->filter()->unique()->implode(', ');
        if ($countries !== '') {
            $tour->country = $countries;
        }
        if ($tour->status === 'published' && ! $tour->published_at) {
            $tour->published_at = now();
        }
        $tour->save();

        $retainedIds = [];
        foreach ($validated['days'] as $index => $day) {
            $record = $tour->days()->updateOrCreate(
                ['day_number' => $index + 1],
                [
                    'title' => $day['title'] ?? '',
                    'location' => $day['location'] ?? null,
                    'description' => $day['description'] ?? null,
                    'accommodation' => $day['accommodation'] ?? null,
                    'meals' => $day['meals'] ?? null,
                ],
            );
            $retainedIds[] = $record->id;
        }
        $tour->days()->whereNotIn('id', $retainedIds)->delete();
    }
}
