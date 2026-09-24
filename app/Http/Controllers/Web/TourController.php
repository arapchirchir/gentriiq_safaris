<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Contracts\View\View;

class TourController extends Controller
{
    public function show(Tour $tour): View
    {
        abort_unless($tour->status === 'published' && $tour->published_at?->isPast(), 404);

        $tour->load(['days', 'destinations', 'experiences']);

        return view('tours.show', compact('tour'));
    }
}
