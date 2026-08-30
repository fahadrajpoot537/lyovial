<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\ThemePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View|RedirectResponse
    {
        return $this->respondTyped(
            Page::TYPE_ABOUT,
            'about',
            'About Us',
            'front.pages.about',
            'A lyophilization specialist, not a generalist CDMO'
        );
    }

    public function quality(): View|RedirectResponse
    {
        return $this->respondTyped(
            Page::TYPE_QUALITY_COMPLIANCE,
            'quality-compliance',
            'Quality & Compliance',
            'front.pages.quality',
            'Where We Stand on Quality — Before It Becomes a Surprise'
        );
    }

    public function specimen(): View|RedirectResponse
    {
        return $this->respondTyped(
            Page::TYPE_SPECIMEN_LIBRARY,
            'specimen-library-preservation',
            'Specimen Library Preservation',
            'front.pages.specimen',
            'Move Your Specimen Library Off the Freezer, Without Losing the Sample'
        );
    }

    public function partnerships(): View|RedirectResponse
    {
        return $this->respondTyped(
            Page::TYPE_PARTNERSHIPS,
            'partnerships',
            'Partnerships',
            'front.pages.partnerships',
            'Two partners we route real work through'
        );
    }

    public function privacy(): View|RedirectResponse
    {
        return $this->respondTyped(
            Page::TYPE_PRIVACY,
            'privacy-policy',
            'Privacy Policy',
            'front.pages.privacy',
            'Privacy Policy'
        );
    }

    public function show(string $slug): View
    {
        abort_if(in_array($slug, Page::reservedSlugs(), true), 404);

        $page = Page::query()
            ->active()
            ->where('slug', $slug)
            ->with('seo')
            ->firstOrFail();

        return match ($page->type) {
            Page::TYPE_QUALITY_COMPLIANCE => view('front.pages.quality', compact('page')),
            Page::TYPE_SPECIMEN_LIBRARY => view('front.pages.specimen', compact('page')),
            Page::TYPE_PARTNERSHIPS => view('front.pages.partnerships', compact('page')),
            Page::TYPE_ABOUT => view('front.pages.about', compact('page')),
            Page::TYPE_PRIVACY => view('front.pages.privacy', compact('page')),
            default => view('front.pages.show', compact('page')),
        };
    }

    protected function respondTyped(
        string $type,
        string $fallbackSlug,
        string $fallbackTitle,
        string $view,
        ?string $fallbackHeading = null
    ): View|RedirectResponse {
        $page = $this->typedPage($type, $fallbackTitle);

        if ($page->exists && filled($page->slug) && $page->slug !== $fallbackSlug) {
            return redirect()->to($page->publicPath(), 301);
        }

        if (! $page->exists && $fallbackHeading && ! filled($page->heading)) {
            $page->heading = $fallbackHeading;
        }

        if ($type === Page::TYPE_PRIVACY && ! $page->exists && ! filled($page->content)) {
            $page->content = ThemePageDefaults::privacyContent();
        }

        return view($view, compact('page'));
    }

    protected function typedPage(string $type, string $fallbackTitle): Page
    {
        $page = Page::query()
            ->ofType($type)
            ->with('seo')
            ->first();

        if ($page) {
            abort_unless($page->status, 404);

            return $page;
        }

        $extra = match ($type) {
            Page::TYPE_QUALITY_COMPLIANCE => ThemePageDefaults::qualityExtra(),
            Page::TYPE_SPECIMEN_LIBRARY => ThemePageDefaults::specimenExtra(),
            Page::TYPE_PARTNERSHIPS => ThemePageDefaults::partnershipsExtra(),
            Page::TYPE_ABOUT => ThemePageDefaults::aboutExtra(),
            Page::TYPE_PRIVACY => ThemePageDefaults::privacyExtra(),
            default => [],
        };

        return new Page([
            'title' => $fallbackTitle,
            'heading' => $fallbackTitle,
            'content' => '',
            'type' => $type,
            'status' => true,
            'extra' => $extra,
        ]);
    }
}
