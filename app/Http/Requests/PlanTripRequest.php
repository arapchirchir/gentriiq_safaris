<?php

namespace App\Http\Requests;

use App\Models\Inquiry;
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
        return [
            // Guests pick one or more experiences that staff have switched on for the planner.
            'experiences' => ['required', 'array', 'min:1', 'max:10'],
            'experiences.*' => ['integer', 'distinct', Rule::exists('experiences', 'id')->where('show_in_planner', true)],

            'tour_id' => ['nullable', 'integer', 'exists:tours,id'],
            'destination_id' => ['nullable', 'integer', 'exists:destinations,id'],

            'traveller_type' => ['required', 'string', Rule::in(['solo', 'partner', 'family', 'group'])],
            'adults_count' => ['required', 'integer', 'min:1', 'max:50'],
            'children_count' => ['nullable', 'integer', 'min:0', 'max:30'],

            'travel_year' => ['required', 'digits:4', 'integer', 'min:'.now()->year, 'max:'.(now()->year + 5)],
            'travel_month' => ['required', 'string', Rule::in([
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December',
            ])],
            'travel_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:'.now()->addDays(10)->toDateString()],
            'travel_season' => ['nullable', 'string', 'max:100'],

            'duration' => ['required', 'string', Rule::in(['2-3_days', '4-6_days', '7-9_days', '10plus_days'])],

            'accommodation_tier' => ['nullable', 'string', Rule::in(['comfort', 'luxury', 'signature_luxury'])],
            'budget_range' => ['nullable', 'string', Rule::in(array_keys(Inquiry::BUDGET_RANGES))],

            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'country' => ['nullable', 'string', 'max:100'],
            'special_requests' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
