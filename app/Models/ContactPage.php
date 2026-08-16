<?php

namespace App\Models;

use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    use HasSeo;

    protected $fillable = [
        'banner_image',
        'heading',
        'description',
        'form_heading',
        'phone',
        'email',
        'address',
        'map_embed',
        'what_to_include_heading',
        'what_to_include_content',
        'how_can_we_help_heading',
        'how_can_we_help_content',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
