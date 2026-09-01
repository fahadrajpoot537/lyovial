<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HomeSectionRequest;
use App\Models\HomeSection;
use App\Support\SeoHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeSectionController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $sections = HomeSection::query()->orderBy('sort_order')->get();
        $sectionKeys = HomeSection::sectionKeys();

        return view('admin.home.index', compact('sections', 'sectionKeys'));
    }

    public function edit(string $key): View
    {
        abort_unless(array_key_exists($key, HomeSection::sectionKeys()), 404);

        $section = HomeSection::query()->firstOrCreate(
            ['section_key' => $key],
            ['sort_order' => array_search($key, array_keys(HomeSection::sectionKeys()), true) ?: 0]
        );

        return view('admin.home.edit', [
            'section' => $section->load('seo'),
            'key' => $key,
            'sectionKey' => $key,
            'sectionLabel' => HomeSection::sectionKeys()[$key],
        ]);
    }

    public function update(HomeSectionRequest $request, string $key): RedirectResponse
    {
        abort_unless(array_key_exists($key, HomeSection::sectionKeys()), 404);

        $section = HomeSection::query()->firstOrCreate(
            ['section_key' => $key],
            ['sort_order' => array_search($key, array_keys(HomeSection::sectionKeys()), true) ?: 0]
        );

        $data = collect($request->validated())->except([
            ...SeoHelper::fields(),
            'stat_items',
            'partner_cards',
            'process_steps',
            'coverage_points',
        ])->all();
        $data['image'] = $this->resolveImageField($request, 'image', 'home-sections', $section->image);

        if (! array_key_exists('extra', $data) || $data['extra'] === null) {
            unset($data['extra']);
        }

        $section->update($data);
        $this->syncSeoFromRequest($request, $request->validated(), $section);
        Cache::forget('home.sections');

        return back()->with('success', 'Home section updated successfully.');
    }
}
