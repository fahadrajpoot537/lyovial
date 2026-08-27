<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Faq;
use App\Models\HomeSection;
use App\Models\Industry;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\WhyChooseItem;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sections = HomeSection::cached()->keyBy('section_key');

        return view('front.home', [
            'sections' => $sections,
            'services' => Service::query()->active()->onHome()->with('seo')->get(),
            'industries' => Industry::query()->active()->onHome()->with('seo')->get(),
            'whyChoose' => WhyChooseItem::query()->active()->orderBy('sort_order')->take(2)->get(),
            'testimonials' => Testimonial::query()->active()->onHome()->orderBy('sort_order')->get(),
            'articles' => Article::query()->active()->published()->onHome()->orderBy('sort_order')->orderByDesc('published_at')->take(3)->get(),
            'faqs' => Faq::query()->active()->forSection('home')->orderBy('sort_order')->get(),
            'seo' => $sections->get('hero')?->seo ?? $sections->get('navbar')?->seo,
            'liteFront' => true,
        ]);
    }
}
