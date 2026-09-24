<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Inquiry::query()->with(['tour', 'destination'])->latest();

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
        $inquiry->load(['tour', 'destination']);

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status'         => ['required', 'string', 'in:new,contacted,quote_sent,confirmed,cancelled'],
            'internal_notes' => ['nullable', 'string', 'max:10000'],
        ]);

        $inquiry->status = $validated['status'];
        $inquiry->internal_notes = $validated['internal_notes'] ?? null;
        $inquiry->save();

        return back()->with('success', "Inquiry {$inquiry->reference} status updated successfully.");
    }
}
