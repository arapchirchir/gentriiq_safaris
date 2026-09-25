<?php

namespace App\Rules;

use App\Actions\SavePhoto;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

/**
 * A photo field holds either an external http(s) link or the path of a file uploaded through SavePhoto.
 */
class PhotoSource implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (SavePhoto::isUploaded($value)) {
            return;
        }

        if (Validator::make(['v' => $value], ['v' => ['string', 'url:http,https', 'max:255']])->fails()) {
            $fail('The :attribute must be an http(s) image link or an uploaded photo.');
        }
    }

    /**
     * Rules for the companion "<field>_upload" file input. SVG is never allowed (it can carry scripts).
     */
    public static function uploadRules(): array
    {
        return ['nullable', File::image()->types(['jpg', 'jpeg', 'png', 'webp'])->max(15 * 1024), 'dimensions:max_width=8000,max_height=8000'];
    }
}
