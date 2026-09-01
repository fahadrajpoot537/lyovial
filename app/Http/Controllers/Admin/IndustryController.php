<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndustryRequest;
use App\Models\Industry;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndustryController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $industries = Industry::query()->orderBy('sort_order')->latest('id')->paginate(20);

        return view('admin.industries.index', compact('industries'));
    }

    public function create(): View
    {
        return view('admin.industries.create');
    }

    public function store(IndustryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated);
        $data['banner_image'] = $this->uploadImage($request, 'banner_image', 'industries');
        $data['image'] = $this->uploadImage($request, 'image', 'industries');
        $data['extra'] = $this->normalizeIndustryExtra($request->input('extra', []));
        $validated['slug'] = $data['slug'];

        $industry = Industry::create(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $validated, $industry);

        return redirect()
            ->route('admin.industries.edit', $industry)
            ->with('success', 'Industry created successfully.');
    }

    public function show(Industry $industry): RedirectResponse
    {
        return redirect()->route('admin.industries.edit', $industry);
    }

    public function edit(Industry $industry): View
    {
        return view('admin.industries.edit', [
            'industry' => $industry->load('seo'),
        ]);
    }

    public function update(IndustryRequest $request, Industry $industry): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated, [], $industry->slug);
        $data['banner_image'] = $this->resolveImageField($request, 'banner_image', 'industries', $industry->banner_image);
        $data['image'] = $this->resolveImageField($request, 'image', 'industries', $industry->image);
        $data['extra'] = $this->normalizeIndustryExtra($request->input('extra', []));
        $validated['slug'] = $data['slug'];

        $oldSlug = $industry->slug;
        $industry->update($data);
        $this->syncSeoFromRequest($request, $validated, $industry);
        $this->rememberSlugRedirect($oldSlug, $data['slug'] ?? $industry->slug, 'industries');

        return back()->with('success', 'Industry updated successfully.');
    }

    public function destroy(Industry $industry): RedirectResponse
    {
        $industry->delete();

        return redirect()
            ->route('admin.industries.index')
            ->with('success', 'Industry deleted successfully.');
    }

    protected function normalizeIndustryExtra(mixed $extra): array
    {
        if (! is_array($extra)) {
            return [];
        }

        $rows = function (mixed $items, array $keys): array {
            return collect($items ?? [])
                ->filter(fn ($row) => is_array($row) && collect($keys)->contains(fn ($key) => filled($row[$key] ?? null)))
                ->values()
                ->all();
        };

        return [
            'nav_title' => $extra['nav_title'] ?? '',
            'hero_eyebrow' => $extra['hero_eyebrow'] ?? '',
            'hero_h1' => $extra['hero_h1'] ?? '',
            'hero_lede' => $extra['hero_lede'] ?? '',
            'spec_heading' => $extra['spec_heading'] ?? '',
            'spec_items' => $rows($extra['spec_items'] ?? [], ['title', 'body']),
            'lead_eyebrow' => $extra['lead_eyebrow'] ?? '',
            'lead_heading' => $extra['lead_heading'] ?? '',
            'lead_paras' => collect($extra['lead_paras'] ?? [])->filter(fn ($row) => filled($row))->values()->all(),
            'needs_eyebrow' => $extra['needs_eyebrow'] ?? '',
            'needs' => $rows($extra['needs'] ?? [], ['title', 'body']),
            'process_eyebrow' => $extra['process_eyebrow'] ?? '',
            'process_heading' => $extra['process_heading'] ?? '',
            'process_intro' => $extra['process_intro'] ?? '',
            'steps' => $rows($extra['steps'] ?? [], ['title', 'body']),
            'why_eyebrow' => $extra['why_eyebrow'] ?? '',
            'why_heading' => $extra['why_heading'] ?? '',
            'why_body' => $extra['why_body'] ?? '',
            'why_items' => collect($extra['why_items'] ?? [])->filter(fn ($row) => filled($row))->values()->all(),
            'related_intro' => $extra['related_intro'] ?? '',
            'workflow_heading' => $extra['workflow_heading'] ?? '',
            'other_industries_heading' => $extra['other_industries_heading'] ?? '',
            'faq_eyebrow' => $extra['faq_eyebrow'] ?? '',
            'faq_heading' => $extra['faq_heading'] ?? '',
            'faq_intro' => $extra['faq_intro'] ?? '',
            'faqs' => $rows($extra['faqs'] ?? [], ['q', 'a']),
            'cta_eyebrow' => $extra['cta_eyebrow'] ?? '',
            'cta_heading' => $extra['cta_heading'] ?? '',
            'cta_body' => $extra['cta_body'] ?? '',
            'cta_button' => $extra['cta_button'] ?? '',
            'cta_link' => $extra['cta_link'] ?? '',
            'swipe_needs' => $extra['swipe_needs'] ?? '',
            'swipe_steps' => $extra['swipe_steps'] ?? '',
        ];
    }
}
