<?php

namespace App\Services;

use finfo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageUploadService
{
    protected array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/jpg',
        'image/heic',
        'image/heif',
        'image/gif',
        'image/svg+xml',
    ];

    protected int $maxFileSize = 35 * 1024 * 1024; // 35MB

    public function upload(
        UploadedFile $file,
        string $directory = 'images',
        bool $useMagick = false
    ): string {
        $this->validateFile($file);

        // Ensure directory starts with uploads/
        $cleanDir = trim($directory, '/');
        $uploadSubDir = str_starts_with($cleanDir, 'uploads') ? $cleanDir : 'uploads/'.$cleanDir;
        $targetPath = public_path($uploadSubDir);

        if (! file_exists($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        if ($useMagick && class_exists('\Imagick')) {
            $image = $this->createImage($file);
            $filename = Str::uuid().'.webp';
            $fullFilePath = $targetPath.'/'.$filename;
            $relativePath = $uploadSubDir.'/'.$filename;

            $this->processAndStore($image, $fullFilePath);

            $image->clear();
            $image->destroy();

            return $relativePath;
        }

        // Standard upload directly to public/uploads/...
        $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
        $file->move($targetPath, $filename);

        return $uploadSubDir.'/'.$filename;
    }

    /**
     * Replace an existing image.
     */
    public function replace(
        UploadedFile $file,
        ?string $oldPath = null,
        string $directory = 'images',
        bool $useMagick = false
    ): string {
        $newPath = $this->upload($file, $directory, $useMagick);

        if ($oldPath) {
            $this->delete($oldPath);
        }

        return $newPath;
    }

    /**
     * Delete an image.
     */
    public function delete(?string $path): void
    {
        if (! $path) {
            return;
        }

        // Remove from public/ directory
        $publicFilePath = public_path(ltrim($path, '/'));
        if (file_exists($publicFilePath) && is_file($publicFilePath)) {
            @unlink($publicFilePath);
            return;
        }

        // Fallback for Storage disk public
        $disk = Storage::disk('public');
        if ($disk->exists($path)) {
            $disk->delete($path);
        }
    }

    protected function validateFile(UploadedFile $file): void
    {
        if (! $file->isValid()) {
            throw ValidationException::withMessages([
                'image' => 'The uploaded file is invalid.',
            ]);
        }

        $mime = $this->detectMimeType($file);

        if (! in_array($mime, $this->allowedMimeTypes, true)) {
            throw ValidationException::withMessages([
                'image' => 'Unsupported image format.',
            ]);
        }
    }

    protected function detectMimeType(UploadedFile $file): string
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $mime = $finfo->file($file->getRealPath());

        if (! $mime) {
            throw ValidationException::withMessages([
                'image' => 'Unable to determine image type.',
            ]);
        }

        return $mime;
    }

    protected function createImage(UploadedFile $file): object
    {
        if (! class_exists('\Imagick')) {
            throw ValidationException::withMessages([
                'image' => 'Imagick extension is not installed on this server.',
            ]);
        }

        try {
            $imagickClass = '\Imagick';
            $image = new $imagickClass;

            $image->readImage($file->getRealPath());

            if ($image->getNumberImages() !== 1) {
                $image->clear();
                $image->destroy();

                throw ValidationException::withMessages([
                    'image' => 'Animated or multi-image files are not allowed.',
                ]);
            }

            $image->setIteratorIndex(0);

            return $image;
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'image' => 'The image could not be processed via Imagick.',
            ]);
        }
    }

    protected function processAndStore(
        object $image,
        string $fullFilePath
    ): void {
        try {
            // Remove EXIF and other metadata.
            $image->stripImage();

            // Flatten certain image formats against a transparent background.
            if ($image->getImageAlphaChannel()) {
                $imagickClass = '\Imagick';
                $image->setImageAlphaChannel($imagickClass::ALPHACHANNEL_ACTIVATE);
            }

            // Re-encode instead of storing the original file.
            $image->setImageFormat('webp');

            $image->setImageCompressionQuality(85);

            $image->setOption('webp:method', '6');

            $contents = $image->getImageBlob();

            file_put_contents($fullFilePath, $contents);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'image' => 'The image could not be processed via Imagick.',
            ]);
        }
    }
}
