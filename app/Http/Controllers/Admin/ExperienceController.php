<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::withCount(['tours', 'inquiries'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create(): View
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $experience = Experience::create($this->validateExperience($request));

        return redirect()->route('admin.experiences.edit', $experience)
            ->with('success', "Experience '{$experience->name}' created successfully.");
    }

    public function edit(Experience $experience): View
    {
        $experience->loadCount(['tours', 'inquiries']);

        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $experience->update($this->validateExperience($request));

        return redirect()->route('admin.experiences.edit', $experience)
            ->with('success', "Experience '{$experience->name}' updated successfully.");
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $inquiries = $experience->inquiries()->count();

        if ($inquiries > 0) {
            return back()->withErrors([
                'experience' => "'{$experience->name}' was chosen on {$inquiries} ".str('inquiry')->plural($inquiries).'. Turn off "Show in trip planner" and "Featured" to hide it instead.',
            ]);
        }

        $name = $experience->name;
        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', "Experience '{$name}' deleted.");
    }

    private function validateExperience(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'url:http,https', 'max:255'],
            'featured' => ['nullable', 'boolean'],
            'show_in_planner' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:2147483647'],
        ]);

        $validated['featured'] = $request->boolean('featured');
        $validated['show_in_planner'] = $request->boolean('show_in_planner');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
