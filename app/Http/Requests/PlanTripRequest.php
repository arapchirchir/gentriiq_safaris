<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validTripTypes = ['safari', 'mountain_trek', 'beach_holiday', 'bush_beach_combined'];

        return [
            // When submitted as an array (normal form flow), each item is validated against the enum.
            'trip_types'    => ['required_without:trip_type', 'array', 'min:1'],
            'trip_types.*'  => ['string', Rule::in($validTripTypes)],

            // When submitted as a pre-joined string, each comma-separated segment must be a valid type.
            // Regex: one or more valid values joined by commas, no leading/trailing commas.
            'trip_type' => [
                'required_without:trip_types',
                'string',
                'regex:/^(safari|mountain_trek|beach_holiday|bush_beach_combined)(,(safari|mountain_trek|beach_holiday|bush_beach_combined))*$/',
            ],

            'tour_id'        => ['nullable', 'integer', 'exists:tours,id'],
            'destination_id' => ['nullable', 'integer', 'exists:destinations,id'],

            'traveller_type' => ['required', 'string', Rule::in(['solo', 'partner', 'family', 'group'])],
            'adults_count'   => ['required', 'integer', 'min:1', 'max:50'],
            'children_count' => ['nullable', 'integer', 'min:0', 'max:30'],

            'travel_year'  => ['required', 'digits:4', 'integer', 'min:' . now()->year, 'max:' . (now()->year + 5)],
            'travel_month' => ['required', 'string', Rule::in([
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December',
            ])],
            'travel_date'   => ['required', 'date_format:Y-m-d', 'after_or_equal:' . now()->addDays(10)->toDateString()],
            'travel_season' => ['nullable', 'string', 'max:100'],

            'duration' => ['required', 'string', Rule::in(['2-3_days', '4-6_days', '7-9_days', '10plus_days'])],

            'accommodation_tier' => ['nullable', 'string', Rule::in(['comfort', 'luxury', 'signature_luxury'])],
            'budget_range'       => ['nullable', 'string', 'max:50'],

            'name'             => ['required', 'string', 'max:120'],
            'email'            => ['required', 'email:rfc', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:30'],
            'whatsapp'         => ['nullable', 'string', 'max:30'],
            'country'          => ['nullable', 'string', 'max:100'],
            'special_requests' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
