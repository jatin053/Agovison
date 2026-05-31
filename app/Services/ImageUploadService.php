<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * @param  array<int, UploadedFile>  $files
     * @return array<int, string>
     */
    public function storeMultiple(array $files, string $directory): array
    {
        return collect($files)
            ->filter()
            ->map(fn (UploadedFile $file) => $this->store($file, $directory))
            ->values()
            ->all();
    }

    public function store(UploadedFile $file, string $directory): string
    {
        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        $absolutePath = Storage::disk('public')->path($path);

        $this->optimize($absolutePath, $file->getMimeType());

        return $path;
    }

    private function optimize(string $absolutePath, ?string $mimeType): void
    {
        if (! extension_loaded('gd') || ! $mimeType) {
            return;
        }

        $image = match ($mimeType) {
            'image/jpeg', 'image/jpg' => function_exists('imagecreatefromjpeg') ? @imagecreatefromjpeg($absolutePath) : null,
            'image/png' => function_exists('imagecreatefrompng') ? @imagecreatefrompng($absolutePath) : null,
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($absolutePath) : null,
            default => null,
        };

        if (! $image) {
            return;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $targetWidth = min(1600, $width);
        $targetHeight = (int) round(($height / max($width, 1)) * $targetWidth);
        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        match ($mimeType) {
            'image/jpeg', 'image/jpg' => imagejpeg($canvas, $absolutePath, 82),
            'image/png' => imagepng($canvas, $absolutePath, 7),
            'image/webp' => function_exists('imagewebp') ? imagewebp($canvas, $absolutePath, 82) : null,
            default => null,
        };

        imagedestroy($image);
        imagedestroy($canvas);
    }
}
