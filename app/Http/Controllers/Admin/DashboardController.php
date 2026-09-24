<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Experience;
use App\Models\Inquiry;
use App\Models\Tour;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $metrics = [
            'total_inquiries' => Inquiry::count(),
            'new_inquiries' => Inquiry::where('status', 'new')->count(),
            'confirmed_inquiries' => Inquiry::where('status', 'confirmed')->count(),
            'in_progress_inquiries' => Inquiry::whereIn('status', ['contacted', 'quote_sent'])->count(),
            'total_tours' => Tour::count(),
            'published_tours' => Tour::published()->count(),
            'total_destinations' => Destination::count(),
            'total_experiences' => Experience::count(),
        ];

        $recentInquiries = Inquiry::with(['tour', 'destination'])
            ->latest()
            ->take(6)
            ->get();

        $featuredTours = Tour::with(['destinations', 'experiences'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('metrics', 'recentInquiries', 'featuredTours'));
    }
}
