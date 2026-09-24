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
Route::post('/plan-your-trip', [TripPlannerController::class, 'store'])->middleware('throttle:5,1')->name('plan.store');
Route::get('/plan-your-trip/{token}', [TripPlannerController::class, 'show'])->middleware('throttle:30,1')->name('plan.show');

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\TourController as AdminTourController;

Route::middleware(['auth', 'role'])->group(function () {
    // Staff Dashboard
    Route::get('/staff', DashboardController::class)->name('admin.dashboard');
    Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');

    // Safari Proposals / Inquiries Management (Sales & Admin)
    Route::middleware(['role:sales,admin,super_admin'])->prefix('staff/inquiries')->name('admin.inquiries.')->group(function () {
        Route::get('/', [AdminInquiryController::class, 'index'])->name('index');
        Route::get('/{inquiry}', [AdminInquiryController::class, 'show'])->name('show');
        Route::put('/{inquiry}', [AdminInquiryController::class, 'update'])->name('update');
    });

    // Tours & Packages Management (Editor & Admin)
    Route::middleware(['role:editor,admin,super_admin'])->prefix('staff/tours')->name('admin.tours.')->group(function () {
        Route::get('/', [AdminTourController::class, 'index'])->name('index');
        Route::get('/{tour}/edit', [AdminTourController::class, 'edit'])->name('edit');
        Route::put('/{tour}', [AdminTourController::class, 'update'])->name('update');
    });
});
