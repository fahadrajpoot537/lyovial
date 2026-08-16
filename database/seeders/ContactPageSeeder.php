<?php

namespace Database\Seeders;

use App\Models\ContactPage;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;

class ContactPageSeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        $banner = $this->demoImage(
            'demo/contact/banner.jpg',
            'Contact LyoVial lyophilization team in Kanata Ontario',
            'Contact LyoVial Banner',
            'Reach LyoVial for cycle development and pilot vial projects'
        );

        $page = ContactPage::current();
        $page->update([
            'banner_image' => $banner,
            'heading' => 'Contact LyoVial',
            'description' => 'Ready to discuss formulation support, lyophilization cycle development, scale-up, technology transfer, or pilot-batch vial production? Send us a message and our Kanata team will respond promptly.',
            'form_heading' => 'Send a Project Inquiry',
            'phone' => '(613) 614-8733',
            'email' => 'info@lyovial.com',
            'address' => $this->addressBlock(),
            'map_embed' => $this->mapEmbed(),
            'what_to_include_heading' => 'What to Include in Your Message',
            'what_to_include_content' => <<<'HTML'
<ul>
<li>Product or material type (reagent, calibrator, control, media component, research sample, other)</li>
<li>Current format (liquid, partially developed lyo cycle, existing lyophilized product)</li>
<li>Target vial size / fill volume if known</li>
<li>Primary goals (stability, shipping robustness, reconstitution, pilot supply, tech transfer)</li>
<li>Approximate timeline and any known constraints</li>
<li>Company name and best contact details</li>
</ul>
<p>The more context you share, the faster we can recommend a practical next step.</p>
HTML,
            'how_can_we_help_heading' => 'How Can We Help?',
            'how_can_we_help_content' => <<<'HTML'
<p>LyoVial supports Canadian partners with:</p>
<ul>
<li>Formulation &amp; lyophilization cycle development</li>
<li>Scale-up planning and technology transfer packages</li>
<li>Pilot-batch vial lyophilization</li>
<li>Guidance for diagnostic, laboratory, research, and specialty ingredient programs</li>
</ul>
<p>Call us at <strong>(613) 614-8733</strong> or email <a href="mailto:info@lyovial.com">info@lyovial.com</a>.</p>
<p><strong>Visit:</strong><br>105 Schneider Road, Unit 123<br>Kanata, Ontario K2K 1Y3<br>Canada</p>
HTML,
        ]);

        $page->syncSeo([
            'seo_title' => 'Contact LyoVial | Kanata Lyophilization Team',
            'meta_title' => 'Contact LyoVial | Pilot-Scale Lyophilization in Kanata, Ontario',
            'meta_description' => 'Contact LyoVial at (613) 614-8733 or info@lyovial.com. Visit 105 Schneider Road, Unit 123, Kanata, Ontario K2K 1Y3 for lyophilization project support.',
            'meta_keywords' => 'contact LyoVial, Kanata lyophilization, freeze drying Canada, info@lyovial.com',
            'canonical_url' => url('/contact'),
            'slug' => 'contact',
            'focus_keyword' => 'contact LyoVial',
            'og_title' => 'Contact LyoVial',
            'og_description' => 'Talk with our Kanata team about cycle development, tech transfer, and pilot vial lyophilization.',
            'og_image' => $banner,
            'twitter_title' => 'Contact LyoVial',
            'twitter_description' => 'Phone (613) 614-8733 · info@lyovial.com · Kanata, Ontario',
            'twitter_image' => $banner,
            'breadcrumb_title' => 'Contact',
            'robots_meta' => 'index, follow',
            'indexable' => true,
            'followable' => true,
            'schema_json' => json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'ContactPage',
                'name' => 'Contact LyoVial',
                'url' => url('/contact'),
                'mainEntity' => [
                    '@type' => 'Organization',
                    'name' => 'LyoVial',
                    'telephone' => '+1-613-614-8733',
                    'email' => 'info@lyovial.com',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => '105 Schneider Road, Unit 123',
                        'addressLocality' => 'Kanata',
                        'addressRegion' => 'ON',
                        'postalCode' => 'K2K 1Y3',
                        'addressCountry' => 'CA',
                    ],
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
        ]);
    }
}
