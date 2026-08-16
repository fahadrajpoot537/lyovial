<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\View\View;

class IndustryController extends Controller
{
    public function index(): View
    {
        $industries = Industry::query()->active()->with('seo')->orderBy('sort_order')->get();

        return view('front.industries.index', compact('industries'));
    }

    public function show(string $slug): View
    {
        $industry = Industry::query()
            ->active()
            ->where('slug', $slug)
            ->with('seo')
            ->firstOrFail();

        $others = Industry::query()
            ->active()
            ->where('id', '!=', $industry->id)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('front.industries.show', compact('industry', 'others'));
    }
}
