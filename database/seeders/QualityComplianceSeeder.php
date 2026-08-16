<?php

namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;

class QualityComplianceSeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        $banner = $this->demoImage(
            'demo/pages/quality-compliance-banner.jpg',
            'Quality and compliance documentation at LyoVial',
            'Quality & Compliance Banner',
            'Quality-minded lyophilization workflows in Kanata, Ontario'
        );

        $page = Page::query()->updateOrCreate(
            ['slug' => 'quality-compliance'],
            [
                'title' => 'Quality & Compliance',
                'type' => Page::TYPE_QUALITY_COMPLIANCE,
                'banner_image' => $banner,
                'heading' => 'Quality & Compliance',
                'content' => <<<'HTML'
<p>LyoVial approaches every lyophilization project with a quality-first mindset. Diagnostic reagents, calibrators, controls, and research materials depend on process discipline, traceability, and clear documentation — not just a finished cake in a vial.</p>

<h2>Our Quality Philosophy</h2>
<p>We design workflows that emphasize controlled handling, batch accountability, and transparent technical communication. Clients receive process clarity they can use internally and with partners during scale-up or technology transfer.</p>

<h2>What Quality Means in Practice</h2>
<ul>
<li><strong>Documented process intent</strong> — freezing, primary drying, and secondary drying parameters captured with rationale</li>
<li><strong>Batch visibility</strong> — notes on execution, observations, and product presentation</li>
<li><strong>Material care</strong> — careful attention to fill, load, and post-lyo handling expectations</li>
<li><strong>Transfer readiness</strong> — information packaged so receiving teams understand critical controls</li>
<li><strong>Continuous improvement</strong> — cycle learnings fed back into future development work</li>
</ul>

<h2>Aligned to Regulated Expectations</h2>
<p>While every client’s quality system is unique, LyoVial works in a manner compatible with the expectations of diagnostic manufacturers and laboratory organizations. We collaborate with your quality and technical teams to meet project-specific documentation and communication requirements.</p>

<h2>Talk to Us About Your Quality Needs</h2>
<p>If your project requires particular records, review checkpoints, or partner handoff packages, tell us early. We will help shape a practical plan that supports both product performance and compliance readiness.</p>
<p>Contact LyoVial at <a href="mailto:info@lyovial.com">info@lyovial.com</a> or <a href="tel:6136148733">(613) 614-8733</a>.</p>
HTML,
                'status' => true,
                'sort_order' => 1,
            ]
        );

        $page->syncSeo([
            'seo_title' => 'Quality & Compliance | LyoVial',
            'meta_title' => 'Quality & Compliance for Lyophilization Projects | LyoVial',
            'meta_description' => 'Learn how LyoVial applies quality-minded documentation, batch accountability, and transfer-ready process controls to lyophilization projects in Canada.',
            'meta_keywords' => 'lyophilization quality, compliance, documentation, technology transfer, Kanata, LyoVial',
            'canonical_url' => url('/quality-compliance'),
            'slug' => 'quality-compliance',
            'focus_keyword' => 'lyophilization quality compliance',
            'og_title' => 'Quality & Compliance | LyoVial',
            'og_description' => 'Quality-first lyophilization workflows with documentation built for diagnostic and laboratory partners.',
            'og_image' => $banner,
            'twitter_title' => 'Quality & Compliance | LyoVial',
            'twitter_description' => 'Controlled lyophilization processes with clear documentation and transfer readiness.',
            'twitter_image' => $banner,
            'breadcrumb_title' => 'Quality & Compliance',
            'robots_meta' => 'index, follow',
            'indexable' => true,
            'followable' => true,
            'schema_json' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Quality & Compliance',
                'url' => url('/quality-compliance'),
                'isPartOf' => ['@type' => 'WebSite', 'name' => 'LyoVial', 'url' => url('/')],
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        ]);
    }
}
