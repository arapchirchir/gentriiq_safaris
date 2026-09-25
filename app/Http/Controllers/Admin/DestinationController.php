<?php

namespace App\Http\Controllers\Admin;

use App\Actions\SavePhoto;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Rules\PhotoSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::withCount('tours')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.destinations.index', compact('destinations'));
    }

    public function create(): View
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateDestination($request);

        $destination = Destination::create($validated);

        return redirect()->route('admin.destinations.edit', $destination)
            ->with('success', "Destination '{$destination->name}' created successfully.");
    }

    public function edit(Destination $destination): View
    {
        $destination->loadCount('tours');

        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $this->validateDestination($request);

        $previousImage = $destination->image;
        $destination->update($validated);
        app(SavePhoto::class)->discard($previousImage, $destination->image);

        return redirect()->route('admin.destinations.edit', $destination)
            ->with('success', "Destination '{$destination->name}' updated successfully.");
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        $name = $destination->name;
        $destination->delete();
        app(SavePhoto::class)->discard($destination->image);

        return redirect()->route('admin.destinations.index')
            ->with('success', "Destination '{$name}' deleted.");
    }

    private function validateDestination(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:100'],
            'featured_badge' => ['nullable', 'string', 'max:50'],
            'summary' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', new PhotoSource],
            'image_upload' => PhotoSource::uploadRules(),
            'featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['featured'] = $request->boolean('featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['image'] = app(SavePhoto::class)->resolve($request->file('image_upload'), $validated['image'] ?? null, 'destinations');
        unset($validated['image_upload']);

        return $validated;
    }
}
