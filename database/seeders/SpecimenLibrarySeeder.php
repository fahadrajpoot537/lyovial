<?php

namespace Database\Seeders;

use App\Models\Page;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;

class SpecimenLibrarySeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        $banner = $this->demoImage(
            'demo/pages/specimen-library-banner.jpg',
            'Specimen library preservation vials at LyoVial',
            'Specimen Library Preservation Banner',
            'Lyophilization support for specimen library preservation programs'
        );

        $page = Page::query()->updateOrCreate(
            ['slug' => 'specimen-library-preservation'],
            [
                'title' => 'Specimen Library Preservation',
                'type' => Page::TYPE_SPECIMEN_LIBRARY,
                'banner_image' => $banner,
                'heading' => 'Specimen Library Preservation',
                'content' => <<<'HTML'
<p>Preserving biological and reagent materials for future use requires stability strategies that protect integrity over time. Lyophilization is a powerful tool for specimen library and archive-oriented programs when moisture removal, packaging format, and reconstitution behaviour are carefully designed.</p>

<h2>How LyoVial Supports Preservation Programs</h2>
<p>We work with laboratories, research groups, and specialized manufacturers that need lyophilized formats for long-term storage, distribution, or controlled rehydration. Our pilot-scale capabilities are well suited to method development and evaluation lots before larger commitments.</p>

<h2>Program Considerations</h2>
<ul>
<li>Material sensitivity to freezing and drying stresses</li>
<li>Target residual moisture for long-term stability</li>
<li>Vial presentation and labeling workflow compatibility</li>
<li>Reconstitution instructions and handling guidance</li>
<li>Documentation needed for internal library management</li>
</ul>

<h2>From Feasibility to Pilot Vials</h2>
<p>LyoVial can help assess whether lyophilization is appropriate, develop an initial cycle concept, and produce pilot vials that your team can evaluate under real handling conditions. When processes mature, we support technology-transfer discussions so your preservation approach can scale with the program.</p>

<h2>Start a Conversation</h2>
<p>Share details about your specimen type, storage goals, preferred vial format, and timeline. Our Kanata team will help map a practical next step.</p>
<p>Email <a href="mailto:vlad@evik.ca">vlad@evik.ca</a> or call <a href="tel:6136148733">(613) 614-8733</a>.</p>
HTML,
                'status' => true,
                'sort_order' => 2,
            ]
        );

        $page->syncSeo([
            'seo_title' => 'Specimen Library Preservation | LyoVial',
            'meta_title' => 'Specimen Library Preservation by Lyophilization | LyoVial',
            'meta_description' => 'LyoVial supports specimen library preservation programs with lyophilization development and pilot vial production from Kanata, Ontario.',
            'meta_keywords' => 'specimen library preservation, lyophilization archive, freeze dried specimens, research preservation, LyoVial',
            'canonical_url' => url('/specimen-library-preservation'),
            'slug' => 'specimen-library-preservation',
            'focus_keyword' => 'specimen library preservation',
            'og_title' => 'Specimen Library Preservation',
            'og_description' => 'Lyophilization strategies for long-term specimen and reagent preservation programs.',
            'og_image' => $banner,
            'twitter_title' => 'Specimen Library Preservation | LyoVial',
            'twitter_description' => 'Pilot-scale freeze-drying support for specimen library and archive initiatives.',
            'twitter_image' => $banner,
            'breadcrumb_title' => 'Specimen Library Preservation',
            'robots_meta' => 'index, follow',
            'indexable' => true,
            'followable' => true,
            'schema_json' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => 'Specimen Library Preservation',
                'url' => url('/specimen-library-preservation'),
                'isPartOf' => ['@type' => 'WebSite', 'name' => 'LyoVial', 'url' => url('/')],
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        ]);
    }
}
