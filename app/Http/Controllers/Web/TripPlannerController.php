<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanTripRequest;
use App\Models\Destination;
use App\Models\Inquiry;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        return view('plan.index', compact('tour', 'destination'));
    }

    public function store(PlanTripRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (! empty($validated['trip_types'])) {
            $validated['trip_type'] = implode(',', $validated['trip_types']);
            unset($validated['trip_types']);
        }

        $travelDate = Carbon::createFromFormat('Y-m-d', $validated['travel_date']);
        $validated['travel_year'] = $travelDate->year;
        $validated['travel_month'] = $travelDate->format('F');

        $validated['children_count'] = $validated['children_count'] ?? 0;
        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();

        $inquiry = Inquiry::create($validated);

        return redirect()->route('plan.show', ['token' => $inquiry->token])
            ->with('success', 'Your safari plan has been created! You can now send it to our planning desk via WhatsApp or keep this link for your records.');
    }

    public function show(string $token): View
    {
        $inquiry = Inquiry::where('token', $token)->firstOrFail();

        return view('plan.show', compact('inquiry'));
    }
}
