<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanTripRequest;
use App\Models\Destination;
use App\Models\Experience;
use App\Models\Inquiry;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripPlannerController extends Controller
{
    public function create(Request $request): View
    {
        $tour = $request->filled('tour')
            ? Tour::published()->where('slug', $request->string('tour'))->first()
            : null;
        $destination = $request->filled('destination')
            ? Destination::where('slug', $request->string('destination'))->first()
            : null;

        $experiences = Experience::inPlanner()->get(['id', 'name', 'summary', 'image']);

        // Arriving from a tour page pre-selects that tour's experiences.
        $selectedExperienceIds = $tour
            ? $tour->experiences()->where('show_in_planner', true)->pluck('experiences.id')->all()
            : [];

        return view('plan.index', compact('tour', 'destination', 'experiences', 'selectedExperienceIds'));
    }

    public function store(PlanTripRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $experienceIds = $validated['experiences'];
        unset($validated['experiences']);

        $travelDate = Carbon::createFromFormat('Y-m-d', $validated['travel_date']);
        $validated['travel_year'] = $travelDate->year;
        $validated['travel_month'] = $travelDate->format('F');

        $validated['children_count'] = $validated['children_count'] ?? 0;
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();

        $inquiry = DB::transaction(function () use ($validated, $experienceIds): Inquiry {
            $inquiry = Inquiry::create($validated);
            $inquiry->experiences()->sync($experienceIds);

            return $inquiry;
        });

        return redirect()->route('plan.show', ['token' => $inquiry->token])
            ->with('success', 'Your safari plan has been created! You can now send it to our planning desk via WhatsApp or keep this link for your records.');
    }

    public function show(string $token): View
    {
        $inquiry = Inquiry::with(['experiences', 'tour', 'destination'])->where('token', $token)->firstOrFail();

        return view('plan.show', compact('inquiry'));
    }
}
