<?php

namespace App\Traits;

use App\Services\ImageUploadService;
use Illuminate\Http\UploadedFile;

trait HasImageUpload
{
    public function uploadImage(
        UploadedFile $file,
        string $directory = 'images',
        bool $useMagick = false
    ): string {
        return app(ImageUploadService::class)->upload(
            $file,
            $directory,
            $useMagick
        );
    }

    public function deleteImage(?string $path): void
    {
        app(ImageUploadService::class)->delete($path);
    }

    public function replaceImage(
        UploadedFile $file,
        ?string $oldPath = null,
        string $directory = 'images',
        bool $useMagick = false
    ): string {
        return app(ImageUploadService::class)->replace(
            $file,
            $oldPath,
            $directory,
            $useMagick
        );
    }
}
