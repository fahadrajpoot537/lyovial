<?php

namespace Database\Seeders;

use App\Models\Industry;
use App\Support\IndustryPageDefaults;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IndustriesSeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        $industries = [
            [
                'title' => 'Diagnostic Assay Reagent Manufacturers',
                'slug' => 'diagnostic-assay-reagent-manufacturers',
                'heading' => 'Diagnostic reagent lyophilization, built to hold through scale-up',
                'short_description' => 'Freeze-dried enzymes, oligos, and detection reagents for IVD kits and lateral-flow assays — cycle development and pilot vial batches, documented to transfer cleanly.',
                'description' => <<<'HTML'
<p>Diagnostic assay developers rely on lyophilization to protect sensitive reagents from hydrolysis, temperature excursions, and logistics complexity. LyoVial partners with reagent manufacturers to develop freeze-drying approaches that preserve analytical performance.</p>
<h2>Typical Needs We Support</h2>
<ul>
<li>Converting liquid reagents to lyophilized formats</li>
<li>Improving cake integrity and reconstitution consistency</li>
<li>Pilot lots for kit assembly and verification</li>
<li>Cycle refinement ahead of technology transfer</li>
</ul>
<p>From early formulation discussions through pilot vial production, we help diagnostic teams build freeze-drying processes that fit real assay requirements.</p>
HTML,
                'file' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 1,
            ],
            [
                'title' => 'Calibrator & Control Producers',
                'slug' => 'calibrator-control-producers',
                'heading' => 'Calibrator and control lyophilization with values that hold',
                'short_description' => 'Freeze-dried calibrators, controls, and QC materials with reproducible reconstitution and stable value assignment across a long shelf life — developed and documented in vial format.',
                'description' => <<<'HTML'
<p>Calibrators and controls must remain precise, stable, and easy to prepare. Lyophilization can extend usability and reduce cold-chain dependence when cycles and formulations are designed carefully.</p>
<p>LyoVial supports calibrator and control producers with formulation guidance, cycle development, and pilot-batch vial lyophilization that prioritize consistency and presentation quality.</p>
HTML,
                'file' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 2,
            ],
            [
                'title' => 'Microbiology Media & Supplement Suppliers',
                'slug' => 'microbiology-media-supplement-suppliers',
                'heading' => 'Microbiology media freeze-drying that rehydrates ready to work',
                'short_description' => 'Freeze-dried culture media, supplements, and enrichment components in vial format — developed so they rehydrate cleanly and perform the way the wet product did.',
                'description' => <<<'HTML'
<p>Microbiology media suppliers often need lyophilized supplements and components that rehydrate cleanly and perform reliably in culture systems. LyoVial helps translate those requirements into workable freeze-drying processes.</p>
<ul>
<li>Pilot vial production for evaluation and partner sampling</li>
<li>Cycle development for moisture-sensitive supplements</li>
<li>Process notes for scale-up discussions</li>
</ul>
HTML,
                'file' => 'https://images.unsplash.com/photo-1576086213369-97a306d36557?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 3,
            ],
            [
                'title' => 'Analytical Testing Laboratories',
                'slug' => 'analytical-testing-laboratories',
                'heading' => 'Reference material lyophilization for testing-lab workflows',
                'short_description' => 'Freeze-dried reference materials, standards, and stabilized reagents — developed for homogeneity, stability, and reconstitution accuracy, with documentation testing labs can stand behind.',
                'description' => <<<'HTML'
<p>Analytical laboratories frequently require small, well-controlled lyophilized lots for method development, reference materials, and specialized testing programs. LyoVial provides accessible pilot-scale freeze-drying support with clear communication and documentation.</p>
HTML,
                'file' => 'https://images.unsplash.com/photo-1581093588401-fbb62a02f120?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 4,
            ],
            [
                'title' => 'University & Institutional R&D Groups',
                'slug' => 'university-institutional-rd-groups',
                'heading' => 'Research sample lyophilization for labs without a lyo specialist',
                'short_description' => 'Freeze-drying for academic and hospital labs — biospecimen library preservation, one-off formulation work, and small research batches, handled by a specialist so your team doesn\'t have to become one.',
                'description' => <<<'HTML'
<p>University and institutional R&amp;D groups often need freeze-drying support beyond standard lab lyophilizers — especially when preparing materials for partner evaluation, grant milestones, or translational programs.</p>
<p>LyoVial works with research teams to develop cycles, produce pilot vials, and document process learnings that can travel with the project as it matures.</p>
HTML,
                'file' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 5,
            ],
            [
                'title' => 'Cosmetic Ingredient Formulators',
                'slug' => 'cosmetic-ingredient-formulators',
                'heading' => 'Cosmetic active lyophilization that keeps the potency in the product',
                'short_description' => 'Freeze-dried cosmetic actives, single-dose beads, and stabilized botanicals for premium skincare — cycles developed to preserve peptide, protein, and botanical potency in an elegant format.',
                'description' => <<<'HTML'
<p>Cosmetic ingredient formulators use lyophilization to protect sensitive actives, improve handling, and create distinctive powdered or cake presentations. LyoVial supports early development and pilot vial work for specialty ingredient programs that benefit from controlled freeze-drying.</p>
HTML,
                'file' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?auto=format&fit=crop&w=900&q=80',
                'sort_order' => 6,
            ],
        ];

        foreach ($industries as $index => $data) {
            $image = $data['file'];
            $banner = $data['file'];

            $industry = Industry::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'banner_image' => $banner,
                    'image' => $image,
                    'heading' => $data['heading'],
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'extra' => IndustryPageDefaults::forSlug($data['slug']),
                    'show_on_home' => true,
                    'status' => true,
                    'sort_order' => $data['sort_order'],
                    'home_sort_order' => $data['sort_order'],
                ]
            );

            $industry->syncSeo([
                'seo_title' => $data['title'].' | LyoVial',
                'meta_title' => $data['heading'].' | LyoVial',
                'meta_description' => Str::limit(strip_tags($data['short_description']), 155, ''),
                'meta_keywords' => 'lyophilization, '.$data['title'].', freeze drying, Canada, LyoVial',
                'canonical_url' => url('/industries/'.$data['slug']),
                'slug' => $data['slug'],
                'focus_keyword' => Str::lower($data['title']),
                'og_title' => $data['heading'],
                'og_description' => $data['short_description'],
                'og_image' => $image,
                'twitter_title' => $data['title'].' | LyoVial',
                'twitter_description' => $data['short_description'],
                'twitter_image' => $image,
                'breadcrumb_title' => $data['title'],
                'robots_meta' => 'index, follow',
                'indexable' => true,
                'followable' => true,
                'schema_json' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Service',
                    'name' => $data['title'],
                    'description' => $data['short_description'],
                    'provider' => ['@type' => 'Organization', 'name' => 'LyoVial'],
                    'url' => url('/industries/'.$data['slug']),
                ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ]);
        }
    }
}
