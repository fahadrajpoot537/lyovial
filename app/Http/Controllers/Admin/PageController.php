<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated);
        $data['banner_image'] = $this->uploadImage($request, 'banner_image', 'pages');
        $data['extra'] = $this->normalizePageExtra($request->input('extra', []), $data['type'] ?? 'custom');
        $data['extra'] = $this->mergeAboutImages($request, $data['type'] ?? 'custom', $data['extra'], []);
        $data['status'] = $request->boolean('status');
        $validated['slug'] = $data['slug'];

        $page = Page::create(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $validated, $page);

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
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated, [], $page->slug);
        $data['banner_image'] = $this->resolveImageField($request, 'banner_image', 'pages', $page->banner_image);
        $data['extra'] = $this->normalizePageExtra($request->input('extra', []), $data['type'] ?? $page->type);
        $data['extra'] = $this->mergeAboutImages($request, $data['type'] ?? $page->type, $data['extra'], is_array($page->extra) ? $page->extra : []);
        $data['status'] = $request->boolean('status');
        $validated['slug'] = $data['slug'];

        $oldSlug = $page->slug;
        $page->update($data);
        $this->syncSeoFromRequest($request, $validated, $page);
        $this->rememberSlugRedirect($oldSlug, $data['slug'] ?? $page->slug);

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

        if ($type === Page::TYPE_PRIVACY) {
            return [
                'effective_date' => trim((string) ($extra['effective_date'] ?? '')),
                'last_updated' => trim((string) ($extra['last_updated'] ?? '')),
                'change_log' => trim((string) ($extra['change_log'] ?? '')),
            ];
        }

        if ($type === Page::TYPE_ABOUT) {
            $tags = $extra['band_tags'] ?? [];
            if (isset($extra['band_tags_text'])) {
                $tags = preg_split('/\r\n|\r|\n/', (string) $extra['band_tags_text']) ?: [];
            }

            return [
                'hero_eyebrow' => $extra['hero_eyebrow'] ?? '',
                'hero_heading' => $extra['hero_heading'] ?? '',
                'hero_sub' => $extra['hero_sub'] ?? '',
                'hero_image' => $extra['hero_image'] ?? '',
                'hero_image_alt' => $extra['hero_image_alt'] ?? '',
                'cards' => collect($extra['cards'] ?? [])
                    ->filter(fn ($row) => is_array($row) && filled($row['title'] ?? null))
                    ->map(fn ($row) => ['title' => $row['title'] ?? '', 'text' => $row['text'] ?? ''])
                    ->values()->all(),
                'origin_eyebrow' => $extra['origin_eyebrow'] ?? '',
                'origin_heading' => $extra['origin_heading'] ?? '',
                'origin_body' => $extra['origin_body'] ?? '',
                'origin_quote' => $extra['origin_quote'] ?? '',
                'origin_image' => $extra['origin_image'] ?? '',
                'origin_image_alt' => $extra['origin_image_alt'] ?? '',
                'expertise_eyebrow' => $extra['expertise_eyebrow'] ?? '',
                'expertise_heading' => $extra['expertise_heading'] ?? '',
                'expertise_body' => $extra['expertise_body'] ?? '',
                'expertise_image' => $extra['expertise_image'] ?? '',
                'expertise_image_alt' => $extra['expertise_image_alt'] ?? '',
                'steps' => collect($extra['steps'] ?? [])
                    ->filter(fn ($row) => is_array($row) && filled($row['title'] ?? null))
                    ->map(fn ($row) => [
                        'num' => $row['num'] ?? '',
                        'title' => $row['title'] ?? '',
                        'body' => $row['body'] ?? '',
                    ])
                    ->values()->all(),
                'band_heading' => $extra['band_heading'] ?? '',
                'band_body' => $extra['band_body'] ?? '',
                'band_tags' => collect($tags)->filter(fn ($v) => filled(trim((string) $v)))->map(fn ($v) => trim((string) $v))->values()->all(),
                'cta_eyebrow' => $extra['cta_eyebrow'] ?? '',
                'cta_heading' => $extra['cta_heading'] ?? '',
                'cta_body' => $extra['cta_body'] ?? '',
                'cta_button' => $extra['cta_button'] ?? '',
                'cta_link' => $extra['cta_link'] ?? '/contact',
            ];
        }

        return null;
    }

    protected function mergeAboutImages(Request $request, string $type, mixed $extra, array $existing = []): mixed
    {
        if ($type !== Page::TYPE_ABOUT || ! is_array($extra)) {
            return $extra;
        }

        $origin = $this->uploadImage($request, 'origin_image_upload', 'pages');
        $expertise = $this->uploadImage($request, 'expertise_image_upload', 'pages');
        $hero = $this->uploadImage($request, 'hero_image_upload', 'pages');

        $extra['origin_image'] = $origin ?: ($extra['origin_image'] ?? ($existing['origin_image'] ?? ''));
        $extra['expertise_image'] = $expertise ?: ($extra['expertise_image'] ?? ($existing['expertise_image'] ?? ''));
        $extra['hero_image'] = $hero ?: ($extra['hero_image'] ?? ($existing['hero_image'] ?? ''));

        if ($request->boolean('remove_origin_image')) {
            $extra['origin_image'] = '';
        }
        if ($request->boolean('remove_expertise_image')) {
            $extra['expertise_image'] = '';
        }
        if ($request->boolean('remove_hero_image')) {
            $extra['hero_image'] = '';
        }

        return $extra;
    }
}
