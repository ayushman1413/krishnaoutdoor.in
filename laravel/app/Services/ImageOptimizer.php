<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Compresses and converts a raster image upload to WebP (PDF: "automatic
 * compression and conversion to WebP"). Falls back to storing the original
 * file untouched if the server's GD/Imagick build can't encode WebP, or if
 * the file isn't a format Intervention can decode — a save should never fail
 * because of this.
 */
class ImageOptimizer
{
    private const QUALITY = 82;

    private const RASTER_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    /**
     * Store $file in $directory as "$filename.webp" when it's a raster image
     * the server can re-encode, otherwise store it unchanged under its
     * original extension (video, gif, or any format WebP conversion fails
     * for). Returns the stored path, same shape as a plain ->storeAs() call,
     * so every existing call site only swaps its storeAs() line for this.
     */
    public static function store(UploadedFile $file, string $directory, string $filename): string
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: '');

        if (!in_array($extension, self::RASTER_EXTENSIONS, true)) {
            return $file->storeAs($directory, $filename . '.' . $extension);
        }

        try {
            $image = Image::make($file->getRealPath());
            $encoded = $image->encode('webp', self::QUALITY);

            $path = $directory . '/' . $filename . '.webp';
            Storage::put($path, (string) $encoded);

            return $path;
        } catch (\Throwable $e) {
            Log::warning('ImageOptimizer: WebP conversion failed, storing original.', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
            ]);

            $extension = $file->getClientOriginalExtension() ?: $file->extension();
            return $file->storeAs($directory, $filename . '.' . $extension);
        }
    }
}
