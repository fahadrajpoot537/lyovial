<?php

namespace App\Services;

use App\Models\ContactInquiry;
use App\Models\Industry;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function stats(): array
    {
        return Cache::remember('admin.dashboard.stats', 60, function () {
            return [
                'pages' => Page::count(),
                'services' => Service::count(),
                'industries' => Industry::count(),
                'inquiries' => ContactInquiry::count(),
                'unread_inquiries' => ContactInquiry::unread()->count(),
            ];
        });
    }

    public function recentInquiries(int $limit = 8)
    {
        return ContactInquiry::query()
            ->latest()
            ->limit($limit)
            ->get();
    }
}
