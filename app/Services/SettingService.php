<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    public function __construct(protected MediaService $mediaService) {}

    public function updateGroup(string $group, array $data, array $fileKeys = []): void
    {
        foreach ($fileKeys as $key) {
            if (isset($data[$key]) && $data[$key] instanceof UploadedFile) {
                $old = Setting::get($key, null, $group);
                $path = $this->mediaService->storePath($data[$key], 'settings');
                $data[$key] = $path;
                if ($old && Storage::disk('public')->exists($old)) {
                    // keep old files for safety; admin can clean via media manager
                }
            } else {
                unset($data[$key]);
            }
        }

        foreach ($data as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }
            Setting::set($key, $value, $group, is_array($value) ? 'json' : 'text');
        }
    }

    public function allGrouped(): array
    {
        return Setting::cached();
    }
}
