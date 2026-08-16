<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUpload
{
    protected function uploadImage(
        Request $request,
        string $field,
        string $folder,
        ?string $existingPath = null,
        bool $deleteOld = false
    ): ?string {
        if ($request->hasFile($field)) {
            if ($deleteOld && $existingPath && Storage::disk('public')->exists($existingPath)) {
                Storage::disk('public')->delete($existingPath);
            }

            return app(MediaService::class)->storePath($request->file($field), $folder);
        }

        $value = $request->input($field);

        if (is_string($value) && $value !== '') {
            return $value;
        }

        return null;
    }

    protected function resolveImageField(Request $request, string $field, string $folder, ?string $existingPath = null): ?string
    {
        $uploaded = $this->uploadImage($request, $field, $folder, $existingPath, deleteOld: true);

        return $uploaded ?? $existingPath;
    }
}
