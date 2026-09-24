<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

    public function edit(Tour $tour): View
    {
        $tour->load(['days', 'destinations', 'experiences']);

        return view('admin.tours.edit', compact('tour'));
    }

    public function update(Request $request, Tour $tour): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string'],
            'starting_price' => ['required', 'numeric', 'min:0'],
            'tour_type' => ['required', 'string', 'in:private,group,both'],
            'status' => ['required', 'string', 'in:draft,published,archived'],
            'featured' => ['nullable', 'boolean'],
        ]);

        $validated['featured'] = $request->boolean('featured');

        if ($validated['status'] === 'published' && ! $tour->published_at) {
            $validated['published_at'] = now();
        }

        $tour->update($validated);

        return redirect()->route('admin.tours.index')
            ->with('success', "Tour '{$tour->title}' updated successfully.");
    }
}
