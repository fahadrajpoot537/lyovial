<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use App\Support\SeoHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $pages = Page::query()->orderBy('sort_order')->latest('id')->paginate(20);

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.create', [
            'types' => Page::types(),
        ]);
    }

    public function store(PageRequest $request): RedirectResponse
    {
        $data = collect($request->validated())->except(SeoHelper::fields())->all();
        $data['banner_image'] = $this->uploadImage($request, 'banner_image', 'pages');
        $data['extra'] = $this->normalizePageExtra($request->input('extra', []), $data['type'] ?? 'custom');

        $page = Page::create(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $request->validated(), $page);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page): RedirectResponse
    {
        return redirect()->route('admin.pages.edit', $page);
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', [
            'page' => $page->load('seo'),
            'types' => Page::types(),
        ]);
    }

    public function update(PageRequest $request, Page $page): RedirectResponse
    {
        $data = collect($request->validated())->except(SeoHelper::fields())->all();
        $data['banner_image'] = $this->resolveImageField($request, 'banner_image', 'pages', $page->banner_image);
        $data['extra'] = $this->normalizePageExtra($request->input('extra', []), $data['type'] ?? $page->type);

        $page->update(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $request->validated(), $page);

        return back()->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    protected function normalizePageExtra(mixed $extra, string $type): ?array
    {
        if (! is_array($extra)) {
            return null;
        }

        if ($type === Page::TYPE_QUALITY_COMPLIANCE) {
            return [
                'hero_eyebrow' => $extra['hero_eyebrow'] ?? '',
                'hero_sub' => $extra['hero_sub'] ?? '',
                'approach_eyebrow' => $extra['approach_eyebrow'] ?? '',
                'approach_heading' => $extra['approach_heading'] ?? '',
                'approach_cards' => collect($extra['approach_cards'] ?? [])
                    ->filter(fn ($row) => is_array($row) && filled($row['title'] ?? null))
                    ->values()->all(),
                'sterility_heading' => $extra['sterility_heading'] ?? '',
                'sterility_body' => $extra['sterility_body'] ?? '',
                'fit_eyebrow' => $extra['fit_eyebrow'] ?? '',
                'fit_heading' => $extra['fit_heading'] ?? '',
                'fit_yes_heading' => $extra['fit_yes_heading'] ?? '',
                'fit_yes' => collect($extra['fit_yes'] ?? [])->filter(fn ($v) => filled($v))->values()->all(),
                'fit_no_heading' => $extra['fit_no_heading'] ?? '',
                'fit_no' => collect($extra['fit_no'] ?? [])->filter(fn ($v) => filled($v))->values()->all(),
                'quote' => $extra['quote'] ?? '',
                'quote_label' => $extra['quote_label'] ?? '',
                'cta_heading' => $extra['cta_heading'] ?? '',
                'cta_body' => $extra['cta_body'] ?? '',
                'cta_button' => $extra['cta_button'] ?? '',
            ];
        }

        if ($type === Page::TYPE_SPECIMEN_LIBRARY) {
            return [
                'hero_eyebrow' => $extra['hero_eyebrow'] ?? '',
                'hero_sub' => $extra['hero_sub'] ?? '',
                'hero_button' => $extra['hero_button'] ?? '',
                'benefits' => collect($extra['benefits'] ?? [])
                    ->filter(fn ($row) => is_array($row) && filled($row['title'] ?? null))
                    ->values()->all(),
                'challenge_eyebrow' => $extra['challenge_eyebrow'] ?? '',
                'challenge_heading' => $extra['challenge_heading'] ?? '',
                'challenge_body' => $extra['challenge_body'] ?? '',
                'solution_eyebrow' => $extra['solution_eyebrow'] ?? '',
                'solution_heading' => $extra['solution_heading'] ?? '',
                'solution_steps' => collect($extra['solution_steps'] ?? [])
                    ->filter(fn ($row) => is_array($row) && filled($row['title'] ?? null))
                    ->values()->all(),
                'stats' => collect($extra['stats'] ?? [])->filter(fn ($v) => filled($v))->values()->all(),
                'faq_eyebrow' => $extra['faq_eyebrow'] ?? '',
                'faq_heading' => $extra['faq_heading'] ?? '',
                'faqs' => collect($extra['faqs'] ?? [])
                    ->filter(fn ($row) => is_array($row) && filled($row['question'] ?? null))
                    ->values()->all(),
                'cta_heading' => $extra['cta_heading'] ?? '',
                'cta_body' => $extra['cta_body'] ?? '',
                'cta_button' => $extra['cta_button'] ?? '',
            ];
        }

        if ($type === Page::TYPE_PARTNERSHIPS) {
            $partners = collect($extra['partners'] ?? [])->map(function ($partner) {
                if (! is_array($partner)) {
                    return null;
                }

                $bullets = $partner['bullets'] ?? [];
                if (isset($partner['bullets_text'])) {
                    $bullets = preg_split('/\r\n|\r|\n/', (string) $partner['bullets_text']) ?: [];
                }

                $methods = $partner['methods'] ?? [];
                if (isset($partner['methods_text'])) {
                    $methods = collect(preg_split('/\r\n|\r|\n/', (string) $partner['methods_text']) ?: [])
                        ->filter(fn ($line) => filled(trim((string) $line)))
                        ->map(function ($line) {
                            [$name, $desc] = array_pad(explode('|', $line, 2), 2, '');

                            return ['name' => trim($name), 'desc' => trim($desc)];
                        })
                        ->filter(fn ($row) => filled($row['name']))
                        ->values()->all();
                }

                return [
                    'num' => $partner['num'] ?? '',
                    'name' => $partner['name'] ?? '',
                    'location' => $partner['location'] ?? '',
                    'title' => $partner['title'] ?? '',
                    'summary' => $partner['summary'] ?? '',
                    'logo' => $partner['logo'] ?? '',
                    'anchor' => $partner['anchor'] ?? '',
                    'website' => $partner['website'] ?? '',
                    'sections' => collect($partner['sections'] ?? [])
                        ->filter(fn ($row) => is_array($row) && filled($row['heading'] ?? null))
                        ->values()->all(),
                    'callout_label' => $partner['callout_label'] ?? '',
                    'callout_body' => $partner['callout_body'] ?? '',
                    'bullets' => collect($bullets)->filter(fn ($v) => filled(trim((string) $v)))->map(fn ($v) => trim((string) $v))->values()->all(),
                    'methods' => $methods,
                ];
            })->filter(fn ($row) => is_array($row) && filled($row['name'] ?? null))->values()->all();

            return [
                'hero_eyebrow' => $extra['hero_eyebrow'] ?? '',
                'hero_heading' => $extra['hero_heading'] ?? '',
                'hero_accent' => $extra['hero_accent'] ?? '',
                'hero_lede' => $extra['hero_lede'] ?? '',
                'partners' => $partners,
                'cta_heading' => $extra['cta_heading'] ?? '',
                'cta_body' => $extra['cta_body'] ?? '',
                'cta_button' => $extra['cta_button'] ?? '',
                'cta_paths' => collect($extra['cta_paths'] ?? [])
                    ->filter(fn ($row) => is_array($row) && filled($row['tag'] ?? null))
                    ->values()->all(),
            ];
        }

        return null;
    }
}
