<?php

namespace Database\Seeders;

use App\Models\HomeSection;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class HomePageSeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        Cache::forget('home.sections');

        $heroImage = '/banner-ab.jpg';

        $aboutImage = '/assets/front/images/lyovial-home/about.jpg';

        $canadaImage = 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?auto=format&fit=crop&w=1000&q=80';

        $sections = [
            'navbar' => [
                'small_title' => 'LyoVial',
                'heading' => 'LyoVial',
                'description' => 'Pilot-scale contract lyophilization & formulation services. Member of the Evik Diagnostics group.',
                'image' => '/lyovial-logo.png',
                'image_alt' => 'LyoVial logo',
                'button_primary_text' => 'Contact',
                'button_primary_link' => '/contact',
                'is_active' => true,
                'sort_order' => 0,
            ],
            'hero' => [
                'small_title' => 'LyoVial — Kanata, Ontario',
                'heading' => 'Contract Lyophilization Services — Pilot-Scale Vial Freeze-Drying',
                'description' => 'Formulation, cycle development, and pilot-batch vial lyophilization for Canadian diagnostics, biotech, and specialty research teams. Built for the projects that outgrow a benchtop dryer but haven\'t reached commercial scale yet.',
                'image' => $heroImage,
                'image_alt' => 'LyoVial lyophilization',
                'button_primary_text' => 'Request a Feasibility Quote →',
                'button_primary_link' => '/contact',
                'button_secondary_text' => null,
                'button_secondary_link' => null,
                'is_active' => true,
                'sort_order' => 1,
            ],
            'about' => [
                'small_title' => 'Who Is LyoVial',
                'heading' => 'Canadian contract lyophilization services, done properly',
                'description' => '<p>LyoVial is a Canadian contract lyophilization company built around one clear idea: pilot-scale, vial-format freeze-drying done properly. We take on the projects that fall in an awkward gap for the big CDMOs — too small for their minimums, too critical for a benchtop unit in your own lab.</p><p>Our clients are diagnostic assay reagent manufacturers, calibrator and control producers, microbiology media and supplement suppliers, analytical testing laboratories, university and institutional R&amp;D groups, and cosmetic ingredient formulators. What they have in common is a formulation that needs a locked, reproducible lyophilization cycle, and a partner who\'ll tell them plainly what will and won\'t work.</p><p>We\'re part of the Evik Diagnostics group of companies. Freeze-drying process expertise across diagnostic applications isn\'t a bolt-on service for us — it\'s what the group has been built around. If you\'ve been looking for contract lyophilization services in Canada from a specialist rather than a generalist CDMO, that\'s the space we sit in.</p>',
                'image' => $aboutImage,
                'image_alt' => 'Who Is LyoVial',
                'button_primary_text' => 'Learn About Quality',
                'button_primary_link' => '/quality-compliance',
                'button_secondary_text' => null,
                'button_secondary_link' => null,
                'is_active' => true,
                'sort_order' => 2,
            ],
            'stats' => [
                'small_title' => 'Stats',
                'heading' => 'By the numbers',
                'description' => null,
                'is_active' => true,
                'sort_order' => 3,
                'extra' => [
                    'items' => [
                        ['num' => '250+', 'label' => "Lyo Cycles<br/>Completed", 'icon' => 'flask'],
                        ['num' => '40+', 'label' => "Client<br/>Programs", 'icon' => 'doc'],
                        ['num' => '12+', 'label' => "Vial Formats<br/>Supported", 'icon' => 'vial'],
                        ['num' => '100%', 'label' => "Documented<br/>Cycles", 'icon' => 'check'],
                    ],
                ],
            ],
            'services' => [
                'small_title' => 'What We Do',
                'heading' => 'Three services covering the full lyophilization workflow',
                'description' => 'Three services that follow the natural sequence of a lyophilization project: work out the formulation, lock the cycle, then produce the pilot batches. Each stage is documented so it can transfer cleanly to your own operation, or to whoever manufactures for you next.',
                'button_primary_text' => 'View All Capabilities',
                'button_primary_link' => '/capabilities',
                'is_active' => true,
                'sort_order' => 4,
            ],
            'industries' => [
                'small_title' => 'Who We Serve',
                'heading' => 'Teams that turn to LyoVial for contract freeze-drying',
                'description' => 'The teams that come to us usually share one of a handful of profiles. If your work falls outside these and involves a lyophilized product, get in touch anyway — we\'ll tell you plainly whether we\'re a fit.',
                'button_primary_text' => 'Explore Industries',
                'button_primary_link' => '/industries',
                'is_active' => true,
                'sort_order' => 5,
            ],
            'why_choose' => [
                'small_title' => 'Why Choose Us',
                'heading' => 'Why teams choose LyoVial for contract lyophilization services',
                'description' => 'There are only a handful of lyophilization companies in Canada that will take on pilot-scale work. Here\'s what separates us from the ones that will — and from the big CDMOs that won\'t.',
                'image' => 'https://images.unsplash.com/photo-1581093458791-9d09c5c1aef2?w=900&auto=format&fit=crop&q=80',
                'button_primary_text' => 'Discover More →',
                'button_primary_link' => '/quality-compliance',
                'is_active' => true,
                'sort_order' => 6,
            ],
            'partner' => [
                'small_title' => 'Partner With Us',
                'heading' => 'Your Canadian partner for pilot-scale contract lyophilization',
                'description' => null,
                'image' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?w=1600&auto=format&fit=crop&q=80',
                'button_primary_text' => 'Partner With Us →',
                'button_primary_link' => '/contact',
                'is_active' => true,
                'sort_order' => 7,
                'extra' => [
                    'cards' => [
                        [
                            'title' => 'Formulation Expertise',
                            'description' => 'Excipient selection, cryoprotectant screening, and thermal characterization done up front — so the cycle you lock in actually holds through scale-up and long-term stability.',
                            'icon' => 'target',
                        ],
                        [
                            'title' => 'Documented Cycle Development',
                            'description' => 'Batch records, cycle parameters, and process notes structured for technology transfer from day one — so the process moves cleanly to whoever manufactures it next.',
                            'icon' => 'flask-beaker',
                        ],
                    ],
                ],
            ],
            'testimonials' => [
                'small_title' => 'Testimonials',
                'heading' => 'What our contract lyophilization clients say',
                'description' => null,
                'is_active' => true,
                'sort_order' => 8,
            ],
            'process' => [
                'small_title' => 'Our Process',
                'heading' => 'How our contract lyophilization services work',
                'description' => 'Every contract lyophilization project follows the same four-stage process — from the first feasibility conversation through documented pilot batches. Each stage is signed off before the next begins, so you know exactly what\'s been locked in, what\'s still open, and what the next manufacturer will receive when the project transfers.',
                'image' => 'https://images.unsplash.com/photo-1581093458791-9d09c5c1aef2?w=600&auto=format&fit=crop&q=80',
                'is_active' => true,
                'sort_order' => 9,
                'extra' => [
                    'steps' => [
                        ['num' => '01', 'title' => "Feasibility &\nConsultation"],
                        ['num' => '02', 'title' => "Formulation &\nExcipient Selection"],
                        ['num' => '03', 'title' => "Lyo Cycle\nDevelopment"],
                        ['num' => '04', 'title' => "Pilot Batch\nProduction"],
                    ],
                ],
            ],
            'articles' => [
                'small_title' => 'Articles',
                'heading' => 'Latest lyophilization insights & case notes',
                'description' => 'Working notes from our cycle development bench — freeze-drying process design, formulation troubleshooting, and what we\'ve learned running contract lyophilization projects for Canadian diagnostic and biotech teams.',
                'is_active' => true,
                'sort_order' => 10,
            ],
            'canada_coverage' => [
                'small_title' => 'Canada Coverage',
                'heading' => 'Lyophilization Services Across Canada',
                'description' => '<p>LyoVial is based in Kanata, Ontario, in the Ottawa area. We work with clients across Canada — from British Columbia biotech labs to Atlantic diagnostic manufacturers — with courier-shipped materials moving between our facility and every province.</p><p>If you\'re doing biotech work in Ottawa or contract manufacturing anywhere in Ontario, we\'re an easy on-site visit. For everyone else, we run the same conversation over video, and material moves by overnight courier with cold-chain handling where the product needs it.</p>',
                'image' => $canadaImage,
                'image_alt' => 'LyoVial Canada coverage from Kanata',
                'map_embed' => $this->mapEmbed(),
                'button_primary_text' => 'Get Directions / Contact',
                'button_primary_link' => '/contact',
                'is_active' => true,
                'sort_order' => 11,
                'extra' => [
                    'points' => [
                        ['title' => 'Ottawa & Kanata', 'text' => 'On-site meetings and facility visits welcome'],
                        ['title' => 'Ontario', 'text' => 'Full local service, same-day courier for most projects'],
                        ['title' => 'Canada-wide', 'text' => 'Standard courier turnaround, no additional lead time'],
                        ['title' => 'Cross-border / international', 'text' => 'Possible on a case-by-case basis — ask'],
                    ],
                ],
            ],
            'faq' => [
                'small_title' => 'Common Questions',
                'heading' => 'Common Questions',
                'description' => 'Things buyers ask us most often before a first call. If your question isn\'t here, send it — we\'ll answer plainly.',
                'is_active' => true,
                'sort_order' => 12,
            ],
            'ready_to_talk' => [
                'small_title' => 'Ready to Talk?',
                'heading' => 'Ready to Talk?',
                'description' => 'Tell us about your formulation, target batch size, and timeline — even if you\'re not sure yet whether lyophilization is the right approach. A short feasibility conversation costs nothing, and it\'s the fastest way to find out whether we\'re a fit.',
                'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1600&q=80',
                'image_alt' => 'Ready to talk — LyoVial feasibility',
                'button_primary_text' => 'Request a Feasibility Quote',
                'button_primary_link' => '/contact',
                'button_secondary_text' => 'Call (613) 614-8733',
                'button_secondary_link' => 'tel:6136148733',
                'is_active' => true,
                'sort_order' => 13,
            ],
            'footer' => [
                'small_title' => 'LyoVial',
                'heading' => 'Pilot-scale contract lyophilization & formulation services',
                'description' => 'Pilot-scale contract lyophilization & formulation services. Member of the Evik Diagnostics group.',
                'image' => '/lyovial-logo.png',
                'image_alt' => 'LyoVial logo',
                'button_primary_text' => 'Contact',
                'button_primary_link' => '/contact',
                'is_active' => true,
                'sort_order' => 14,
                'extra' => [
                    'copyright' => '© '.date('Y').' LyoVial. All Rights Reserved. | Contract lyophilization services based in Ottawa, serving Canada-wide.',
                ],
            ],
        ];

        foreach ($sections as $key => $data) {
            HomeSection::query()->updateOrCreate(
                ['section_key' => $key],
                $data
            );
        }
    }

}
