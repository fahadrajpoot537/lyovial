<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'uuid',
        'user_id',
        'disk',
        'path',
        'webp_path',
        'filename',
        'original_name',
        'mime_type',
        'extension',
        'size',
        'width',
        'height',
        'alt_text',
        'title',
        'caption',
        'description',
        'seo_name',
        'lazy_load',
        'folder',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'lazy_load' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Media $media) {
            if (empty($media->uuid)) {
                $media->uuid = (string) Str::uuid();
            }
        });

        static::deleting(function (Media $media) {
            if ($media->isForceDeleting()) {
                Storage::disk($media->disk)->delete(array_filter([$media->path, $media->webp_path]));
                foreach (array_filter([$media->path, $media->webp_path]) as $filePath) {
                    $copy = public_path('uploads/'.$filePath);
                    if (is_file($copy)) {
                        @unlink($copy);
                    }
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return storage_url($this->path) ?: Storage::disk($this->disk)->url($this->path);
    }

    public function getWebpUrlAttribute(): ?string
    {
        return $this->webp_path ? Storage::disk($this->disk)->url($this->webp_path) : null;
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}
