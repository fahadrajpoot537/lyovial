<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    public function run(): void
    {
        Faq::query()->where('section', 'home')->delete();

        $faqs = [
            [
                'question' => 'Is lyophilization the same as freeze drying?',
                'answer' => 'Yes. Lyophilization and freeze drying refer to the same process: removing water from a frozen product under vacuum so ice sublimes directly to vapor. The terms are used interchangeably in diagnostics, biotech, and contract manufacturing.',
                'sort_order' => 1,
            ],
            [
                'question' => 'What batch sizes do you handle?',
                'answer' => 'We focus on pilot-scale vial lyophilization — the step between benchtop development and commercial manufacturing. Exact capacity depends on vial format and cycle design; tell us your target batch size and we\'ll confirm fit on the first call.',
                'sort_order' => 2,
            ],
            [
                'question' => 'Do you handle GMP lyophilization work?',
                'answer' => 'We operate quality-minded, documented workflows suited to diagnostic and laboratory development. If your project requires a specific GMP tier beyond our scope, we\'ll say so plainly and help you understand what documentation from our pilot work will transfer to a GMP manufacturer.',
                'sort_order' => 3,
            ],
            [
                'question' => 'What products do you lyophilize?',
                'answer' => 'Typical work includes diagnostic assay reagents, calibrators and controls, microbiology media and supplements, analytical reference materials, university and institutional R&D samples, and specialty cosmetic actives — all in vial formats.',
                'sort_order' => 4,
            ],
            [
                'question' => 'How long does lyophilization cycle development take?',
                'answer' => 'Timing depends on formulation complexity, characterization needs, and scheduling. Many programs start with a feasibility discussion, then move into targeted cycle trials. We\'ll give you a realistic timeline once we understand your material and goals.',
                'sort_order' => 5,
            ],
            [
                'question' => 'Where is LyoVial located and can I visit?',
                'answer' => 'We are at 105 Schneider Road, Unit 123, Kanata, Ontario K2K 1Y3 — in the Ottawa area. On-site meetings and facility visits are welcome for Ottawa and Ontario partners. Call (613) 614-8733 or email info@lyovial.com to arrange a visit.',
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::query()->create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'section' => 'home',
                'status' => true,
                'sort_order' => $faq['sort_order'],
            ]);
        }
    }
}
