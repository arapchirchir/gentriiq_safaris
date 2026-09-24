<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'trip_types' => ['required_without:trip_type', 'array', 'min:1'],
            'trip_types.*' => ['string', 'in:safari,mountain_trek,beach_holiday,bush_beach_combined'],
            'trip_type' => ['required_without:trip_types', 'string'],
            'tour_id' => ['nullable', 'integer', 'exists:tours,id'],
            'destination_id' => ['nullable', 'integer', 'exists:destinations,id'],
            'traveller_type' => ['required', 'string', 'in:solo,partner,family,group'],
            'adults_count' => ['required', 'integer', 'min:1', 'max:50'],
            'children_count' => ['nullable', 'integer', 'min:0', 'max:30'],
            'travel_year' => ['required', 'string', 'max:10'],
            'travel_month' => ['required', 'string', 'max:20'],
            'travel_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:' . now()->addDays(10)->toDateString()],
            'travel_season' => ['nullable', 'string', 'max:50'],
            'duration' => ['required', 'string', 'in:2-3_days,4-6_days,7-9_days,10plus_days'],
            'accommodation_tier' => ['nullable', 'string', 'in:comfort,luxury,signature_luxury'],
            'budget_range' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'country' => ['nullable', 'string', 'max:100'],
            'special_requests' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
