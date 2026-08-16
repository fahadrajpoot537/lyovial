<?php

namespace Database\Seeders;

use App\Models\Setting;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        $logo = $this->demoImage(
            'demo/branding/logo.svg',
            'LyoVial company logo',
            'LyoVial Logo',
            'LyoVial — Canadian lyophilization specialists'
        );

        $favicon = $this->demoImage(
            'demo/branding/favicon.svg',
            'LyoVial favicon',
            'LyoVial Favicon'
        );

        $og = $this->demoImage(
            'demo/branding/default-og.svg',
            'LyoVial open graph default image',
            'LyoVial Default Open Graph Image',
            'Pilot-scale vial lyophilization in Kanata, Ontario'
        );

        $settings = [
            'general' => [
                'site_name' => 'LyoVial',
                'phone' => '(613) 614-8733',
                'email' => 'info@lyovial.com',
                'address' => $this->addressBlock(),
                'map_embed' => $this->mapEmbed(),
                'copyright' => '© '.date('Y').' LyoVial. All Rights Reserved. | Contract lyophilization services based in Ottawa, serving Canada-wide.',
                'logo' => '/lyovial-logo.png',
                'favicon' => '/theme/assets/images/lyovial/logo.png',
            ],
            'social' => [
                'facebook' => 'https://www.facebook.com/lyovial',
                'twitter' => 'https://twitter.com/lyovial',
                'linkedin' => 'https://www.linkedin.com/company/lyovial',
                'instagram' => 'https://www.instagram.com/lyovial',
                'youtube' => 'https://www.youtube.com/@lyovial',
            ],
            'seo' => [
                'site_title' => 'LyoVial',
                'default_canonical_url' => url('/'),
                'organization_name' => 'LyoVial',
                'organization_logo' => $logo,
                'organization_phone' => '(613) 614-8733',
                'organization_email' => 'info@lyovial.com',
                'organization_address' => $this->addressBlock(),
                'default_meta_title' => 'LyoVial | Pilot-Scale Vial Lyophilization in Canada',
                'default_meta_description' => 'LyoVial provides formulation support, lyo cycle development, scale-up, technology transfer, and pilot-batch vial lyophilization from Kanata, Ontario.',
                'default_meta_keywords' => 'lyophilization, freeze drying, vial lyophilization, cycle development, Kanata, Ontario, Canada, diagnostics, reagents',
                'default_og_title' => 'LyoVial | Canadian Lyophilization Specialists',
                'default_og_description' => 'Pilot-scale vial lyophilization for diagnostics, reagents, microbiology media, analytical labs, and research groups across Canada.',
                'default_og_image' => $og,
                'default_twitter_title' => 'LyoVial | Canadian Lyophilization Specialists',
                'default_twitter_description' => 'Pilot-scale vial lyophilization for diagnostics, reagents, microbiology media, analytical labs, and research groups across Canada.',
                'default_twitter_card' => 'summary_large_image',
                'default_twitter_image' => $og,
                'sitemap_enabled' => '1',
                'sitemap_changefreq' => 'weekly',
            ],
            'analytics' => [
                'google_analytics' => '',
                'google_tag_manager' => '',
                'google_search_console' => '',
                'bing_verification' => '',
                'meta_pixel' => '',
                'linkedin_insight_tag' => '',
                'robots_txt' => "User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml'),
            ],
            'scripts' => [
                'custom_head_scripts' => '',
                'custom_footer_scripts' => '',
            ],
            'contact' => [
                'phone' => '(613) 614-8733',
                'email' => 'info@lyovial.com',
                'address' => $this->addressBlock(),
                'map_embed' => $this->mapEmbed(),
            ],
        ];

        foreach ($settings as $group => $items) {
            foreach ($items as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['group' => $group, 'key' => $key],
                    ['value' => $value, 'type' => str_contains($key, 'embed') || str_contains($key, 'scripts') || $key === 'robots_txt' ? 'text' : 'text']
                );
            }
        }

        Setting::flushCache();
    }
}
