<?php

namespace App\Actions;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Stores admin photo uploads as web-ready WebP files on the public disk.
 *
 * Every upload is decoded and re-encoded, which strips EXIF/GPS metadata from
 * phone photos and neutralises files disguised as images. Stored values are
 * root-relative paths (/storage/uploads/...) so they survive APP_URL changes.
 */
class SavePhoto
{
    public const MAX_EDGE = 2000;

    public const QUALITY = 82;

    public const PATH_PATTERN = '#^/storage/uploads/(tours|destinations|experiences)/[0-9a-f-]{36}\.webp$#';

    /**
     * Return the value to save: a new upload wins over a pasted link or the existing value.
     */
    public function resolve(?UploadedFile $upload, ?string $submitted, string $folder): ?string
    {
        if ($upload) {
            return $this->store($upload, $folder);
        }

        return filled($submitted) ? $submitted : null;
    }

    public function store(UploadedFile $upload, string $folder): string
    {
        $image = $this->decode($upload->getRealPath());
        $image = $this->scaleDown($image);

        $path = "uploads/{$folder}/".Str::uuid().'.webp';

        ob_start();
        imagewebp($image, null, self::QUALITY);
        Storage::disk('public')->put($path, (string) ob_get_clean());
        imagedestroy($image);

        return '/storage/'.$path;
    }

    /**
     * Delete the previous file once it is no longer referenced (replaced, cleared or its record deleted).
     */
    public function discard(?string $previous, ?string $current = null): void
    {
        if (self::isUploaded($previous) && $previous !== $current) {
            Storage::disk('public')->delete(Str::after($previous, '/storage/'));
        }
    }

    public static function isUploaded(?string $value): bool
    {
        return is_string($value) && preg_match(self::PATH_PATTERN, $value) === 1;
    }

    private function decode(string $file): GdImage
    {
        $type = getimagesize($file)[2] ?? null;

        $image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($file),
            IMAGETYPE_PNG => imagecreatefrompng($file),
            IMAGETYPE_WEBP => imagecreatefromwebp($file),
            default => false,
        };

        if (! $image instanceof GdImage) {
            throw new RuntimeException('Unsupported or corrupt image.');
        }

        // Phones store rotation in EXIF instead of rotating pixels; apply it before metadata is dropped.
        if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $orientation = @exif_read_data($file)['Orientation'] ?? 1;
            $image = match ((int) $orientation) {
                3 => imagerotate($image, 180, 0),
                6 => imagerotate($image, -90, 0),
                8 => imagerotate($image, 90, 0),
                default => $image,
            };
        }

        return $image;
    }

    private function scaleDown(GdImage $image): GdImage
    {
        $width = imagesx($image);
        $height = imagesy($image);
        $ratio = min(1, self::MAX_EDGE / max($width, $height));

        if ($ratio === 1) {
            return $image;
        }

        $scaled = imagecreatetruecolor((int) round($width * $ratio), (int) round($height * $ratio));
        imagealphablending($scaled, false);
        imagesavealpha($scaled, true);
        imagecopyresampled($scaled, $image, 0, 0, 0, 0, imagesx($scaled), imagesy($scaled), $width, $height);
        imagedestroy($image);

        return $scaled;
    }
}
