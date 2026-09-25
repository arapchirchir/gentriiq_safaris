<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Inquiry::query()->with(['tour', 'destination', 'experiences'])->latest();

        if ($status && in_array($status, ['new', 'contacted', 'quote_sent', 'confirmed', 'cancelled'], true)) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%")
                    ->orWhere('reference', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%");
            });
        }

        $inquiries = $query->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => Inquiry::count(),
            'new' => Inquiry::where('status', 'new')->count(),
            'contacted' => Inquiry::where('status', 'contacted')->count(),
            'quote_sent' => Inquiry::where('status', 'quote_sent')->count(),
            'confirmed' => Inquiry::where('status', 'confirmed')->count(),
            'cancelled' => Inquiry::where('status', 'cancelled')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'statusCounts', 'status', 'search'));
    }

    public function show(Inquiry $inquiry): View
    {
        $inquiry->load(['tour', 'destination', 'experiences', 'updates']);

        // Quoting head start: published packages sharing the guest's chosen experiences, best match first.
        $experienceIds = $inquiry->experiences->modelKeys();
        $matchingTours = $experienceIds === [] ? collect() : Tour::published()
            ->when($inquiry->tour_id, fn ($query, $tourId) => $query->whereKeyNot($tourId))
            ->whereHas('experiences', fn ($query) => $query->whereKey($experienceIds))
            ->withCount(['experiences as matching_experiences_count' => fn ($query) => $query->whereKey($experienceIds)])
            ->orderByDesc('matching_experiences_count')
            ->orderBy('starting_price')
            ->limit(6)
            ->get();

        return view('admin.inquiries.show', compact('inquiry', 'matchingTours'));
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(array_keys(Inquiry::STATUSES))],
            'note' => ['nullable', 'string', 'max:5000'],
        ]);

        $note = trim((string) ($validated['note'] ?? ''));
        $previousStatus = $inquiry->status;

        if ($note === '' && $validated['status'] === $previousStatus) {
            return back()->withErrors(['note' => 'Write a note about this follow-up or change the status.']);
        }

        $user = $request->user();

        DB::transaction(function () use ($inquiry, $validated, $note, $previousStatus, $user): void {
            $inquiry->status = $validated['status'];
            $inquiry->save();

            // Author is always the signed-in staff member; names are copied so history survives account removal.
            $inquiry->updates()->forceCreate([
                'user_id' => $user->id,
                'author_name' => $user->name,
                'author_role' => $user->role_label,
                'status' => $validated['status'],
                'previous_status' => $previousStatus,
                'note' => $note !== '' ? $note : null,
            ]);
        });

        return back()->with('success', "Inquiry {$inquiry->reference} updated and added to the follow-up history.");
    }
}
