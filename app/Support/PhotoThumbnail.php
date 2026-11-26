<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class PhotoThumbnail
{
    public static function create(string $originalPath): string
    {
        $disk = Storage::disk('public');
        $sourcePath = $disk->path($originalPath);

        if (! is_file($sourcePath)) {
            throw new RuntimeException('File foto asli tidak ditemukan.');
        }

        $imageInfo = getimagesize($sourcePath);

        if ($imageInfo === false) {
            throw new RuntimeException('File foto tidak valid.');
        }

        [$originalWidth, $originalHeight] = $imageInfo;

        $source = match ($imageInfo['mime']) {
            'image/jpeg' => imagecreatefromjpeg($sourcePath),
            'image/png' => imagecreatefrompng($sourcePath),
            'image/webp' => imagecreatefromwebp($sourcePath),
            default => false,
        };

        if ($source === false) {
            throw new RuntimeException('Gagal membaca foto.');
        }

        $scale = min(
            1,
            800 / $originalWidth,
            600 / $originalHeight
        );

        $width = max(1, (int) round($originalWidth * $scale));
        $height = max(1, (int) round($originalHeight * $scale));

        $thumbnail = imagecreatetruecolor($width, $height);

        if ($thumbnail === false) {
            imagedestroy($source);
            throw new RuntimeException('Gagal membuat thumbnail.');
        }

        imagealphablending($thumbnail, false);
        imagesavealpha($thumbnail, true);

        $transparent = imagecolorallocatealpha($thumbnail, 0, 0, 0, 127);
        imagefill($thumbnail, 0, 0, $transparent);

        imagecopyresampled(
            $thumbnail,
            $source,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $originalWidth,
            $originalHeight
        );

        $directory = 'thumbnails/event-documentation';

        $disk->makeDirectory($directory);

        $thumbnailPath = $directory.'/'.Str::uuid().'.webp';
        $destinationPath = $disk->path($thumbnailPath);

        $saved = imagewebp($thumbnail, $destinationPath, 78);

        imagedestroy($source);
        imagedestroy($thumbnail);

        if (! $saved) {
            $disk->delete($thumbnailPath);

            throw new RuntimeException('Gagal menyimpan thumbnail.');
        }

        return $thumbnailPath;
    }
}