<?php

use App\Models\Setting;
use App\Support\RobotsTxt;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $current = trim((string) Setting::get('robots_txt', '', 'analytics'));
        $clean = trim((string) preg_replace('/^Sitemap:.*\r?\n?/mi', '', $current));

        if ($clean === '') {
            $clean = RobotsTxt::DEFAULT_BODY;
        }

        Setting::set('robots_txt', $clean, 'analytics', 'text');
    }

    public function down(): void
    {
        //
    }
};
