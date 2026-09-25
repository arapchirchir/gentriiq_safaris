<?php

namespace App\Http\Requests;

use App\Actions\RenderRichText;
use App\Models\Destination;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class SaveTourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isEditor() && $this->user()->is_active;
    }

    protected function prepareForValidation(): void
    {
        $defaults = [];
        foreach (['days', 'destinations', 'experiences', 'highlights', 'inclusions', 'exclusions'] as $field) {
            if (! $this->exists($field)) {
                $defaults[$field] = [];
            }
        }
        if (! $this->exists('featured')) {
            $defaults['featured'] = false;
        }
        $this->merge($defaults);
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $exception = new ValidationException($validator);
        $exception->errorBag = $this->errorBag;
        $exception->response = redirect($this->getRedirectUrl())
            ->withInput($this->all())
            ->withErrors($validator->errors(), $this->errorBag);

        throw $exception;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required_if:status,published', 'nullable', 'string', 'max:500'],
            'description' => ['required_if:status,published', 'nullable', 'string', 'max:100000'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:365'],
            'duration_nights' => ['required', 'integer', 'min:0', 'lt:duration_days'],
            'starting_price' => ['required', 'numeric', 'decimal:0,2', 'min:0', 'max:99999999.99', Rule::when($this->input('status') === 'published', ['gt:0'])],
            'currency' => ['nullable', 'string', 'in:USD,EUR,GBP,KES'],
            'tour_type' => ['required', 'string', 'in:private,group,both'],
            'difficulty' => ['nullable', 'string', 'in:easy,moderate,challenging,extreme'],
            'badge' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:255'],
            'location_summary' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['required_if:status,published', 'nullable', 'url:http,https', 'max:255'],
            'status' => ['required', 'string', 'in:draft,published,archived'],
            'featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:2147483647'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'highlights' => ['present', 'array', 'max:100'],
            'highlights.*' => ['nullable', 'string', 'max:255'],
            'inclusions' => ['present', 'array', 'max:100'],
            'inclusions.*' => ['nullable', 'string', 'max:255'],
            'exclusions' => ['present', 'array', 'max:100'],
            'exclusions.*' => ['nullable', 'string', 'max:255'],
            'destinations' => ['required_if:status,published', 'array', 'max:100'],
            'destinations.*' => ['integer', 'distinct', 'exists:destinations,id'],
            'experiences' => ['present', 'array', 'max:100'],
            'experiences.*' => ['integer', 'distinct', 'exists:experiences,id'],
            'days' => ['present', 'array', 'list', 'max:365'],
            'days.*' => ['array:day_number,title,location,description,accommodation,meals'],
            'days.*.day_number' => ['sometimes', 'integer', 'min:1'],
            'days.*.title' => ['required_if:status,published', 'nullable', 'string', 'max:255'],
            'days.*.location' => ['nullable', 'string', 'max:255'],
            'days.*.description' => ['required_if:status,published', 'nullable', 'string', 'max:20000'],
            'days.*.accommodation' => ['nullable', 'string', 'max:255'],
            'days.*.meals' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator): void {
            if (! $validator->errors()->hasAny(['duration_days', 'days'])) {
                $count = count($this->input('days', []));
                $duration = $this->integer('duration_days');
                if ($count > $duration || ($this->input('status') === 'published' && $count !== $duration)) {
                    $validator->errors()->add('days', "The itinerary has {$count} days. Published tours need exactly {$duration} days; drafts may have fewer, but never more.");
                }
            }

            if (! $validator->errors()->hasAny(['destinations', 'destinations.*'])) {
                $countries = Destination::whereIn('id', $this->input('destinations', []))->orderBy('country')->pluck('country')->filter()->unique()->implode(', ');
                if (mb_strlen($countries) > 255) {
                    $validator->errors()->add('destinations', 'The combined country names must fit within 255 characters.');
                }
            }

            if ($this->input('status') === 'published' && ! $validator->errors()->has('description')) {
                $text = html_entity_decode(strip_tags(app(RenderRichText::class)($this->input('description'))), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (preg_match('/^[\s\p{Z}\x{200B}]*$/u', $text)) {
                    $validator->errors()->add('description', 'Enter a meaningful overview before publishing.');
                }
            }
        }];
    }

    public function attributes(): array
    {
        return [
            'days.*.title' => 'itinerary day :position title',
            'days.*.description' => 'itinerary day :position description',
            'duration_nights' => 'number of nights',
            'destinations' => 'destinations',
        ];
    }
}
