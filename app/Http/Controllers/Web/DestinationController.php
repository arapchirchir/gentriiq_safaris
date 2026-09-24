<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Contracts\View\View;

class DestinationController extends Controller
{
    public function show(Destination $destination): View
    {
        $destination->load([
            'tours' => fn($query) => $query
                ->published()
                ->with('destinations')
                ->orderBy('sort_order'),
        ]);

        return view('destinations.show', compact('destination'));
    }
}
