<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\ThemePageDefaults;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page = $this->typedPage(Page::TYPE_ABOUT, 'About Us');
        if (! $page->heading) {
            $page->heading = 'A lyophilization specialist, not a generalist CDMO';
        }

        return view('front.pages.about', compact('page'));
    }

    public function quality(): View
    {
        $page = $this->typedPage(Page::TYPE_QUALITY_COMPLIANCE, 'Quality & Compliance');
        if (! $page->heading) {
            $page->heading = 'Where We Stand on Quality — Before It Becomes a Surprise';
        }

        return view('front.pages.quality', compact('page'));
    }

    public function specimen(): View
    {
        $page = $this->typedPage(Page::TYPE_SPECIMEN_LIBRARY, 'Specimen Library Preservation');
        if (! $page->heading) {
            $page->heading = 'Move Your Specimen Library Off the Freezer, Without Losing the Sample';
        }

        return view('front.pages.specimen', compact('page'));
    }

    public function partnerships(): View
    {
        $page = $this->typedPage(Page::TYPE_PARTNERSHIPS, 'Partnerships');
        if (! $page->heading) {
            $page->heading = 'Two partners we route real work through';
        }

        return view('front.pages.partnerships', compact('page'));
    }

    public function privacy(): View
    {
        $page = $this->typedPage(Page::TYPE_PRIVACY, 'Privacy Policy');
        if (! $page->heading) {
            $page->heading = 'Privacy Policy';
        }
        if (! filled($page->content)) {
            $page->content = ThemePageDefaults::privacyContent();
        }

        return view('front.pages.privacy', compact('page'));
    }

    public function show(string $slug): View
    {
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

    protected function typedPage(string $type, string $fallbackTitle): Page
    {
        $page = Page::query()
            ->active()
            ->ofType($type)
            ->with('seo')
            ->first();

        if (! $page) {
            $extra = match ($type) {
                Page::TYPE_QUALITY_COMPLIANCE => ThemePageDefaults::qualityExtra(),
                Page::TYPE_SPECIMEN_LIBRARY => ThemePageDefaults::specimenExtra(),
                Page::TYPE_PARTNERSHIPS => ThemePageDefaults::partnershipsExtra(),
                Page::TYPE_ABOUT => ThemePageDefaults::aboutExtra(),
                Page::TYPE_PRIVACY => ThemePageDefaults::privacyExtra(),
                default => [],
            };

            $page = new Page([
                'title' => $fallbackTitle,
                'heading' => $fallbackTitle,
                'content' => '',
                'type' => $type,
                'status' => true,
                'extra' => $extra,
            ]);
        }

        return $page;
    }
}
