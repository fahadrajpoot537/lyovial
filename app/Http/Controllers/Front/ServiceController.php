<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()->active()->with('seo')->orderBy('sort_order')->get();

        return view('front.services.index', compact('services'));
    }

    public function show(string $slug): View
    {
        $service = Service::query()
            ->active()
            ->where('slug', $slug)
            ->with(['seo', 'galleries'])
            ->firstOrFail();

        $others = Service::query()
            ->active()
            ->where('id', '!=', $service->id)
            ->orderBy('sort_order')
            ->get();

        $allServices = Service::query()->active()->orderBy('sort_order')->get();
        $sidebarServices = $allServices->map(fn (Service $row) => [
            'title' => $row->title,
            'url' => url('/capabilities/'.$row->slug),
            'active' => $row->id === $service->id,
        ])->values()->all();

        $sidebarServices[] = [
            'title' => 'Quality & Compliance',
            'url' => url('/quality-compliance'),
            'active' => false,
        ];
        $sidebarServices[] = [
            'title' => 'Specimen Library Preservation',
            'url' => url('/specimen-library-preservation'),
            'active' => false,
        ];

        return view('front.services.show', compact('service', 'others', 'sidebarServices'));
    }
}
