<?php

namespace App\Services;

use App\Models\ManagedFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerService
{
    public function upload(UploadedFile $file, string $folder = 'documents', ?array $meta = null): ManagedFile
    {
        $folder = trim($folder, '/');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $base.'-'.Str::random(8).'.'.$extension;
        $path = $file->storeAs($folder, $filename, 'public');

        return ManagedFile::create([
            'user_id' => Auth::id(),
            'disk' => 'public',
            'path' => $path,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'extension' => $extension,
            'size' => $file->getSize() ?: 0,
            'folder' => $folder,
            'title' => $meta['title'] ?? $file->getClientOriginalName(),
            'description' => $meta['description'] ?? null,
        ]);
    }

    public function delete(ManagedFile $file, bool $force = false): void
    {
        if ($force) {
            Storage::disk($file->disk)->delete($file->path);
            $file->forceDelete();
        } else {
            $file->delete();
        }
    }
}
