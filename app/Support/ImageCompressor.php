<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;
use RuntimeException;

class ImageCompressor
{
    private const MAX_SIZE = 2 * 1024 * 1024;

    /**
     * Kompres gambar menjadi WebP maksimal 2 MB.
     */
    public function compress(UploadedFile $file): string
    {
        $manager = new ImageManager(new Driver);

        $image = $manager->read($file->getPathname());

        // Perbaiki orientasi berdasarkan metadata EXIF.
        $image->orient();

        $width = $image->width();
        $height = $image->height();

        // Coba beberapa tingkat kualitas terlebih dahulu.
        $qualities = [85, 80, 75, 70, 65, 60, 55, 50, 45, 40];

        for ($attempt = 0; $attempt < 10; $attempt++) {
            foreach ($qualities as $quality) {
                $processed = clone $image;

                if ($attempt > 0) {
                    $scale = pow(0.85, $attempt);

                    $processed->scaleDown(
                        width: max(1, (int) ($width * $scale)),
                        height: max(1, (int) ($height * $scale))
                    );
                }

                $encoded = $processed->encode(
                    new WebpEncoder(quality: $quality)
                );

                $result = $encoded->toString();

                if (strlen($result) <= self::MAX_SIZE) {
                    return $result;
                }
            }
        }

        throw new RuntimeException(
            'Foto gagal dikompres hingga ukuran maksimal 2 MB.'
        );
    }
}
