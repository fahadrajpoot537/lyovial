<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactPage;
use App\Models\Faq;
use App\Models\HomeSection;
use App\Models\Industry;
use App\Models\Menu;
use App\Models\Service;
use App\Models\Setting;
use App\Models\WhyChooseItem;
use App\Services\Recaptcha;
use Illuminate\Http\JsonResponse;

class ThemeDataController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $sections = HomeSection::cached()->keyBy('section_key');
        $services = Service::query()->active()->orderBy('sort_order')->limit(6)->get();
        $industries = Industry::query()->active()->orderBy('sort_order')->limit(6)->get();
        $menus = Menu::tree('header');
        $contact = ContactPage::current();
        $faqs = Faq::query()->active()->forSection('home')->orderBy('sort_order')->limit(10)->get();
        $whyChoose = WhyChooseItem::query()->active()->orderBy('sort_order')->limit(4)->get();

        $canada = $sections->get('canada_coverage');

        return response()->json([
            'csrf_token' => csrf_token(),
            'recaptcha_site_key' => Recaptcha::siteKey(),
            'site' => [
                'name' => Setting::get('site_name', 'LyoVial', 'general'),
                'phone' => Setting::get('phone', '', 'general'),
                'email' => Setting::get('email', '', 'general'),
                'address' => Setting::get('address', '', 'general'),
                'logo_url' => storage_url(Setting::get('logo', null, 'general')),
                'footer_copyright' => Setting::get('copyright', '', 'general')
                ?: ($sections->get('footer')?->extra['copyright'] ?? null)
                ?: ('© '.date('Y').' LyoVial. All Rights Reserved.'),
            ],
            'sections' => [
                'hero' => $sections->get('hero'),
                'about' => $sections->get('about'),
                'services' => $sections->get('services'),
                'industries' => $sections->get('industries'),
                'why_choose' => $sections->get('why_choose'),
                'canada_coverage' => $canada,
                'faq' => $sections->get('faq'),
                'ready_to_talk' => $sections->get('ready_to_talk'),
                'footer' => $sections->get('footer'),
            ],
            'menus' => $menus->map(function ($menu) {
                $hasChildren = $menu->children->isNotEmpty();

                return [
                    'title' => $menu->title,
                    'url' => $hasChildren ? '#' : $menu->resolved_url,
                    'is_dropdown' => $hasChildren || $menu->type === 'dropdown',
                    'children' => $menu->children->map(fn ($child) => [
                        'title' => $child->title,
                        'url' => $child->resolved_url,
                    ])->values(),
                ];
            })->values(),
            'services' => $services->map(fn ($service) => [
                'title' => $service->title,
                'url' => url('/capabilities/'.$service->slug),
                'description' => $service->short_description,
                'image_url' => storage_url($service->featured_image ?: $service->banner_image),
            ])->values(),
            'industries' => $industries->map(fn ($industry) => [
                'title' => $industry->title,
                'url' => url('/industries/'.$industry->slug),
                'description' => $industry->short_description,
                'image_url' => storage_url($industry->image ?: $industry->banner_image),
            ])->values(),
            'why_choose_items' => $whyChoose->map(fn ($item) => [
                'title' => $item->title,
                'description' => $item->description,
            ])->values(),
            'canada_points' => collect($canada?->extra['points'] ?? [])->values(),
            'faqs' => $faqs->map(fn ($faq) => [
                'question' => $faq->question,
                'answer' => $faq->answer,
            ])->values(),
            'contact' => [
                'heading' => $contact->heading,
                'description' => $contact->description,
                'form_heading' => $contact->form_heading,
                'phone' => $contact->phone,
                'email' => $contact->email,
                'address' => $contact->address,
                'map_embed' => $contact->map_embed ?: $canada?->map_embed,
            ],
        ]);
    }
}
