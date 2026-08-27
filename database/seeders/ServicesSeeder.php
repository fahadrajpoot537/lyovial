<?php

namespace Database\Seeders;

use App\Models\Service;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        $services = [
            [
                'title' => 'Formulation & Lyo Cycle Development',
                'slug' => 'formulation-lyo-cycle-development',
                'page_heading' => 'Formulation & Lyophilization Cycle Development',
                'short_description' => 'We work from your existing liquid formulation, or help you build one from scratch, and design a freeze-drying cycle around it. Every stage — from excipient selection to a final, reproducible process — is documented.',
                'long_description' => <<<'HTML'
<p>Successful lyophilization begins with the right formulation and a cycle grounded in product thermal behaviour. LyoVial helps you develop freeze-drying strategies for diagnostic reagents, calibrators, controls, media components, and research materials that must remain stable, reconstitutable, and transportable.</p>
<h2>What We Help You Define</h2>
<ul>
<li>Excipient and bulking agent selection for cake structure and protection</li>
<li>Buffer systems compatible with freezing and drying stresses</li>
<li>Critical temperatures that guide safe primary drying conditions</li>
<li>Freezing, annealing (where useful), primary drying, and secondary drying profiles</li>
<li>Target residual moisture and reconstitution expectations</li>
</ul>
<h2>Development Approach</h2>
<p>We combine formulation science with iterative cycle trials to build a practical design space. The goal is a reproducible process that preserves performance while remaining efficient enough for pilot and future scale-up work.</p>
<p>Whether you are converting a liquid reagent to a lyophilized format or refining an existing cycle that is too long, collapses, or fails stability expectations, our team provides structured development support with clear recommendations.</p>
<h2>Ideal For</h2>
<ul>
<li>New lyophilized assay reagent programs</li>
<li>Calibrator and control reformulation projects</li>
<li>Products needing improved cake quality or reconstitution time</li>
<li>Teams preparing for technology transfer</li>
</ul>
HTML,
                'button_text' => 'Discuss Cycle Development',
                'button_link' => '/contact',
                'breadcrumb_title' => 'Formulation & Cycle Development',
                'show_on_home' => true,
                'is_featured' => true,
                'sort_order' => 1,
                'home_sort_order' => 1,
                'banner' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1200&q=80',
                'featured' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=900&q=80',
                'seo' => [
                    'seo_title' => 'Formulation & Lyo Cycle Development | LyoVial',
                    'meta_title' => 'Formulation & Lyophilization Cycle Development | LyoVial',
                    'meta_description' => 'LyoVial develops lyophilization formulations and freeze-drying cycles for diagnostic reagents, calibrators, media, and research materials in Kanata, Ontario.',
                    'meta_keywords' => 'lyophilization cycle development, formulation development, freeze drying, residual moisture, cake structure, Kanata',
                    'canonical_url' => url('/capabilities/formulation-lyo-cycle-development'),
                    'slug' => 'formulation-lyo-cycle-development',
                    'focus_keyword' => 'lyophilization cycle development',
                    'og_title' => 'Formulation & Lyo Cycle Development',
                    'og_description' => 'Build robust freeze-drying formulations and cycles with LyoVial’s pilot-scale development team.',
                    'twitter_title' => 'Formulation & Lyo Cycle Development | LyoVial',
                    'twitter_description' => 'Formulation science and freeze-drying cycle design for Canadian diagnostic and research partners.',
                    'breadcrumb_title' => 'Formulation & Cycle Development',
                    'robots_meta' => 'index, follow',
                    'indexable' => true,
                    'followable' => true,
                    'schema_json' => json_encode([
                        '@context' => 'https://schema.org',
                        '@type' => 'Service',
                        'name' => 'Formulation & Lyo Cycle Development',
                        'provider' => ['@type' => 'Organization', 'name' => 'LyoVial'],
                        'areaServed' => 'Canada',
                        'url' => url('/capabilities/formulation-lyo-cycle-development'),
                    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                ],
            ],
            [
                'title' => 'Scale-Up',
                'slug' => 'scale-up-technology-transfer',
                'page_heading' => 'Scale-Up',
                'short_description' => 'Once a cycle is set at feasibility scale, we scale it up to pilot-batch size. Every parameter is documented as it moves from a handful of vials to a full pilot run.',
                'long_description' => <<<'HTML'
<p>Moving a lyophilized product from development into broader production requires more than a working small-batch cycle. LyoVial supports scale-up planning and technology transfer so your process remains scientifically grounded and operationally practical.</p>
<h2>Transfer-Ready Deliverables</h2>
<ul>
<li>Process summaries covering freezing, primary drying, and secondary drying</li>
<li>Critical process parameter guidance and rationale</li>
<li>Batch execution notes and observed product characteristics</li>
<li>Recommendations for equipment differences and risk points</li>
<li>Support for internal handoff conversations with your production partners</li>
</ul>
<h2>How We Reduce Transfer Risk</h2>
<p>We document what matters: cake appearance expectations, moisture targets, reconstitution behaviour, hold points, and known sensitivities. That clarity helps your receiving team avoid trial-and-error when equipment, load patterns, or vial configurations change.</p>
<p>Whether you are transferring to an internal suite or an external manufacturing partner, LyoVial helps package development knowledge into an actionable technical package.</p>
HTML,
                'button_text' => 'Plan a Transfer',
                'button_link' => '/contact',
                'breadcrumb_title' => 'Scale-Up',
                'show_on_home' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'home_sort_order' => 2,
                'banner' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80',
                'featured' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=900&q=80',
                'seo' => [
                    'seo_title' => 'Scale-Up & Technology Transfer | LyoVial',
                    'meta_title' => 'Lyophilization Scale-Up & Technology Transfer | LyoVial',
                    'meta_description' => 'Transfer lyophilization processes from development to production with clear documentation, parameter guidance, and Canadian technical support from LyoVial.',
                    'meta_keywords' => 'lyophilization scale-up, technology transfer, freeze drying transfer, process package, Canada',
                    'canonical_url' => url('/capabilities/scale-up-technology-transfer'),
                    'slug' => 'scale-up-technology-transfer',
                    'focus_keyword' => 'lyophilization technology transfer',
                    'og_title' => 'Scale-Up & Technology Transfer',
                    'og_description' => 'Move freeze-drying processes from pilot development to production with transferable documentation.',
                    'twitter_title' => 'Scale-Up & Technology Transfer | LyoVial',
                    'twitter_description' => 'Technology transfer support for lyophilized reagents, calibrators, and research materials.',
                    'breadcrumb_title' => 'Scale-Up & Tech Transfer',
                    'robots_meta' => 'index, follow',
                    'indexable' => true,
                    'followable' => true,
                    'schema_json' => json_encode([
                        '@context' => 'https://schema.org',
                        '@type' => 'Service',
                        'name' => 'Scale-Up & Technology Transfer',
                        'provider' => ['@type' => 'Organization', 'name' => 'LyoVial'],
                        'areaServed' => 'Canada',
                        'url' => url('/capabilities/scale-up-technology-transfer'),
                    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                ],
            ],
            [
                'title' => 'Pilot-Batch Vial Lyophilization',
                'slug' => 'pilot-batch-vial-lyophilization',
                'page_heading' => 'Pilot-Batch Vial Lyophilization',
                'short_description' => 'Small and mid-size pilot runs of lyophilized vials for R&D, product launch, validation studies, and early commercial supply. Glass vial formats sized to your product. Documented, consistent, run-to-run — the vial lyophilization service most bench-scale programs step up to next.',
                'long_description' => <<<'HTML'
<p>LyoVial provides pilot-batch vial lyophilization for organizations that need high-quality freeze-dried materials before full commercial launch. Pilot lots support assay verification, customer sampling, stability programs, and internal process confirmation.</p>
<h2>Pilot Production Support</h2>
<ul>
<li>Vial fill and lyophilization for development and evaluation lots</li>
<li>Process execution aligned to agreed cycle parameters</li>
<li>Visual cake assessment and batch notes</li>
<li>Support for residual moisture and reconstitution expectations</li>
<li>Coordination for Canadian shipping and partner handoff</li>
</ul>
<h2>When Pilot Batches Matter</h2>
<p>Pilot lyophilization is often the bridge between laboratory feasibility and broader release readiness. It allows your team to evaluate real vial presentation, confirm handling characteristics, and generate data without over-committing to large-scale manufacturing.</p>
<p>Contact LyoVial to discuss vial formats, fill volumes, batch size expectations, and documentation needs for your next pilot run.</p>
HTML,
                'button_text' => 'Request Pilot Batch Info',
                'button_link' => '/contact',
                'breadcrumb_title' => 'Pilot-Batch Lyophilization',
                'show_on_home' => true,
                'is_featured' => true,
                'sort_order' => 3,
                'home_sort_order' => 3,
                'banner' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=1200&q=80',
                'featured' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=900&q=80',
                'seo' => [
                    'seo_title' => 'Pilot-Batch Vial Lyophilization | LyoVial',
                    'meta_title' => 'Pilot-Batch Vial Lyophilization Services | LyoVial Canada',
                    'meta_description' => 'Order pilot-batch vial lyophilization from LyoVial in Kanata for diagnostics, reagents, microbiology media, and research applications across Canada.',
                    'meta_keywords' => 'pilot batch lyophilization, vial freeze drying, pilot lyo, diagnostic reagents, Canada',
                    'canonical_url' => url('/capabilities/pilot-batch-vial-lyophilization'),
                    'slug' => 'pilot-batch-vial-lyophilization',
                    'focus_keyword' => 'pilot-batch vial lyophilization',
                    'og_title' => 'Pilot-Batch Vial Lyophilization',
                    'og_description' => 'Controlled pilot vial freeze-drying for evaluation, stability, and pre-commercial needs.',
                    'twitter_title' => 'Pilot-Batch Vial Lyophilization | LyoVial',
                    'twitter_description' => 'Pilot lyophilized vial lots produced in Kanata, Ontario for Canadian partners.',
                    'breadcrumb_title' => 'Pilot-Batch Lyophilization',
                    'robots_meta' => 'index, follow',
                    'indexable' => true,
                    'followable' => true,
                    'schema_json' => json_encode([
                        '@context' => 'https://schema.org',
                        '@type' => 'Service',
                        'name' => 'Pilot-Batch Vial Lyophilization',
                        'provider' => ['@type' => 'Organization', 'name' => 'LyoVial'],
                        'areaServed' => 'Canada',
                        'url' => url('/capabilities/pilot-batch-vial-lyophilization'),
                    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                ],
            ],
        ];

        foreach ($services as $data) {
            $banner = $data['banner'];
            $featured = $data['featured'];

            $seo = $data['seo'];
            $seo['og_image'] = $featured;
            $seo['twitter_image'] = $featured;

            $service = Service::query()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'banner_image' => $banner,
                    'featured_image' => $featured,
                    'page_heading' => $data['page_heading'],
                    'short_description' => $data['short_description'],
                    'long_description' => $data['long_description'],
                    'button_text' => $data['button_text'],
                    'button_link' => $data['button_link'],
                    'breadcrumb_title' => $data['breadcrumb_title'],
                    'show_on_home' => $data['show_on_home'],
                    'status' => true,
                    'is_featured' => $data['is_featured'],
                    'sort_order' => $data['sort_order'],
                    'home_sort_order' => $data['home_sort_order'],
                ]
            );

            $service->syncSeo($seo);

            if ($service->galleries()->count() === 0) {
                $service->galleries()->create([
                    'image' => $featured,
                    'alt_text' => $data['title'].' process visual',
                    'title' => $data['title'].' Gallery Image',
                    'sort_order' => 0,
                ]);
            }
        }
    }
}
