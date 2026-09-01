<?php

use App\Support\SeoPageDefaults;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SeoPageDefaults::fixLiposomalSlug();
        SeoPageDefaults::persistFrontUniques();
    }

    public function down(): void
    {
        // Titles remain in seo_meta; slug redirect can be deactivated in admin if needed.
    }
};
