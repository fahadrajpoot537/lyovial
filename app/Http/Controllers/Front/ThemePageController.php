<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\SeoHeadService;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class ThemePageController extends Controller
{
    public function __construct(protected SeoHeadService $seoHead) {}

    public function home(): View
    {
        return $this->render('index-2.html', 'Home');
    }

    public function page(?string $file = null, ?string $title = null, ?string $slug = null): View
    {
        return $this->render($file ?: 'index-2.html', $title, $slug);
    }

    public function serviceDetail(string $slug): View
    {
        $map = [
            'formulation-lyo-cycle-development' => 'service-d-artificial.html',
            'scale-up-technology-transfer' => 'service-d-research.html',
            'pilot-batch-vial-lyophilization' => 'service-d-pathology.html',
        ];

        return $this->render($map[$slug] ?? 'services.html', 'Service', $slug);
    }

    protected function render(string $file, ?string $title = null, ?string $slug = null): View
    {
        $path = public_path('theme/'.$file);

        abort_unless(File::exists($path), 404);

        $html = File::get($path);

        $html = preg_replace('#(href|src)=["\']assets/#', '$1="/theme/assets/', $html);
        $html = preg_replace('#url\(\s*assets/#', 'url(/theme/assets/', $html);
        $html = preg_replace('#url\(["\']assets/#', 'url("/theme/assets/', $html);

        $replacements = [
            'href="index.html"' => 'href="/"',
            'href="index-2.html"' => 'href="/"',
            'href="services.html"' => 'href="/capabilities"',
            'href="services-2.html"' => 'href="/industries"',
            'href="contact.html"' => 'href="/contact"',
            'href="about.html"' => 'href="/quality-compliance"',
            'href="faq.html"' => 'href="/specimen-library-preservation"',
        ];
        $html = str_replace(array_keys($replacements), array_values($replacements), $html);
        $html = str_replace(
            ['/services/', '"/services"', "'/services'", 'href="/services"'],
            ['/capabilities/', '"/capabilities"', "'/capabilities'", 'href="/capabilities"'],
            $html
        );

        $body = $html;
        if (preg_match('/<body[^>]*>(.*)<\/body>/is', $html, $matches)) {
            $body = $matches[1];
        }

        // Drop theme chrome — shared Blade navbar/footer/banner are used instead
        $body = preg_replace('/<div class="preloader">.*?<\/div>/is', '', $body) ?? $body;
        $body = preg_replace('/<!--\s*\.preloader[\s\S]*?-->/i', '', $body) ?? $body;
        $body = preg_replace('/<header\b[^>]*>.*?<\/header>/is', '', $body) ?? $body;
        $body = preg_replace('/<div class="[^"]*main-header[^"]*"[\s\S]*?<\/div>\s*(?=<section|<div class="page)/i', '', $body) ?? $body;
        $body = preg_replace('/<section\b[^>]*class=["\'][^"\']*page-header[^"\']*["\'][\s\S]*?<\/section>/i', '', $body) ?? $body;
        $body = preg_replace('/<footer\b[^>]*>.*?<\/footer>/is', '', $body) ?? $body;
        $body = preg_replace('/<!--\s*Footer[\s\S]*?-->/i', '', $body) ?? $body;
        $body = preg_replace('/<a href=["\']#[^"\']*["\'][^>]*class=["\'][^"\']*scroll-to-top[^"\']*["\'][\s\S]*?<\/a>/i', '', $body) ?? $body;
        $body = preg_replace('/<script\b[^>]*src=["\'][^"\']*cms-bind\.js["\'][^>]*>\s*<\/script>/i', '', $body) ?? $body;

        $seoData = $this->seoHead->resolve(request(), $title, $slug);

        return view('front.theme-page', [
            'themeContent' => $body,
            'seo' => (object) [
                'meta_title' => $seoData['title'] ?? null,
                'meta_description' => $seoData['description'] ?? null,
                'meta_keywords' => $seoData['keywords'] ?? null,
                'canonical_url' => $seoData['canonical'] ?? null,
                'robots_meta' => $seoData['robots'] ?? null,
                'og_title' => $seoData['og_title'] ?? null,
                'og_description' => $seoData['og_description'] ?? null,
                'og_image' => $seoData['og_image'] ?? null,
                'twitter_title' => $seoData['twitter_title'] ?? null,
                'twitter_description' => $seoData['twitter_description'] ?? null,
                'twitter_image' => $seoData['twitter_image'] ?? null,
                'schema_json' => ! empty($seoData['schema'][0]) ? $seoData['schema'][0] : null,
                'indexable' => true,
                'followable' => true,
            ],
            'pageTitle' => $title,
        ]);
    }
}
