<?php

namespace App\Services;

/**
 * Versioned URLs for files in the public folder: "?v=<mtime>" changes
 * whenever the file changes, so .htaccess can cache them for a year
 * ("immutable") without visitors ever getting a stale copy.
 */
class Asset
{
    public static function url(string $path): string
    {
        $path = ltrim($path, '/');
        $mtime = @filemtime(public_path($path));

        return asset($path) . ($mtime ? '?v=' . $mtime : '');
    }
}
