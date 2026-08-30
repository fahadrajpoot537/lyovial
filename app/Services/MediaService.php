<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class MediaService
{
    public function upload(
        UploadedFile $file,
        string $folder = 'uploads',
        ?array $meta = null,
        bool $compress = true,
        bool $webp = true
    ): Media {
        $folder = trim($folder, '/');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $seoName = $meta['seo_name'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = Str::slug($seoName).'-'.Str::random(8).'.'.$extension;
        $path = $file->storeAs($folder, $filename, 'public');

        $width = null;
        $height = null;
        $webpPath = null;
        $size = $file->getSize() ?: 0;

        if ($this->isImage($file)) {
            try {
                $image = Image::read($file->getRealPath());

                if ($compress) {
                    $image->scaleDown(width: 2000);
                    $encoded = $image->encodeByExtension($extension, quality: 82);
                    Storage::disk('public')->put($path, (string) $encoded);
                    $size = Storage::disk('public')->size($path);
                    $image = Image::read(Storage::disk('public')->path($path));
                }

                $width = $image->width();
                $height = $image->height();

                if ($webp && $extension !== 'webp' && $extension !== 'svg') {
                    $webpFilename = pathinfo($filename, PATHINFO_FILENAME).'.webp';
                    $webpPath = $folder.'/'.$webpFilename;
                    Storage::disk('public')->put($webpPath, (string) $image->toWebp(80));
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $this->mirrorPublic($path);
        if ($webpPath) {
            $this->mirrorPublic($webpPath);
        }

        return Media::create([
            'user_id' => Auth::id(),
            'disk' => 'public',
            'path' => $path,
            'webp_path' => $webpPath,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'extension' => $extension,
            'size' => $size,
            'width' => $width,
            'height' => $height,
            'alt_text' => $meta['alt_text'] ?? null,
            'title' => $meta['title'] ?? $seoName,
            'caption' => $meta['caption'] ?? null,
            'seo_name' => Str::slug($seoName),
            'folder' => $folder,
        ]);
    }

    public function replace(Media $media, UploadedFile $file, bool $compress = true, bool $webp = true): Media
    {
        Storage::disk($media->disk)->delete(array_filter([$media->path, $media->webp_path]));

        $uploaded = $this->upload($file, $media->folder, [
            'alt_text' => $media->alt_text,
            'title' => $media->title,
            'caption' => $media->caption,
            'seo_name' => $media->seo_name ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
        ], $compress, $webp);

        $media->forceDelete();

        return $uploaded;
    }

    public function delete(Media $media, bool $force = false): void
    {
        if ($force) {
            $media->forceDelete();
        } else {
            $media->delete();
        }
    }

    public function storePath(UploadedFile $file, string $folder = 'uploads'): string
    {
        return $this->upload($file, $folder)->path;
    }

    protected function mirrorPublic(string $path): void
    {
        $from = Storage::disk('public')->path($path);
        if (! is_file($from)) {
            return;
        }

        $to = public_path('uploads/'.$path);
        $dir = dirname($to);
        if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
            return;
        }

        @copy($from, $to);
    }

    protected function isImage(UploadedFile $file): bool
    {
        return str_starts_with((string) $file->getMimeType(), 'image/')
            && ! in_array(strtolower($file->getClientOriginalExtension()), ['svg'], true);
    }
}
