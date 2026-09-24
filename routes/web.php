<?php

use App\Http\Controllers\Web\DestinationController;
use App\Http\Controllers\Web\TourController;
use App\Http\Controllers\Web\TripPlannerController;
use App\Models\Destination;
use App\Models\Experience;
use App\Models\Tour;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredTours = Tour::query()
        ->published()
        ->featured()
        ->with(['destinations', 'experiences'])
        ->get();

    $destinations = Destination::query()
        ->featured()
        ->get();

    $experiences = Experience::query()
        ->featured()
        ->get();

    return view('welcome', compact('featuredTours', 'destinations', 'experiences'));
})->name('home');

Route::get('/tours/{tour:slug}', [TourController::class, 'show'])->name('tours.show');
Route::get('/destinations/{destination:slug}', [DestinationController::class, 'show'])->name('destinations.show');
Route::get('/plan-your-trip', [TripPlannerController::class, 'create'])->name('plan.create');
Route::post('/plan-your-trip', [TripPlannerController::class, 'store'])->name('plan.store');
Route::get('/plan-your-trip/{token}', [TripPlannerController::class, 'show'])->name('plan.show');

Route::view('/staff', 'auth.dashboard')->middleware('auth')->name('dashboard');
