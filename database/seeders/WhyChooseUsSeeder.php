<?php

namespace Database\Seeders;

use App\Models\WhyChooseItem;
use Database\Seeders\Concerns\SeedsDemoMedia;
use Illuminate\Database\Seeder;

class WhyChooseUsSeeder extends Seeder
{
    use SeedsDemoMedia;

    public function run(): void
    {
        WhyChooseItem::query()->delete();

        $items = [
            [
                'title' => 'Formulation-first, not just a service run',
                'description' => 'Most freeze drying services will run whatever cycle you hand them. We start with the formulation — because a bad cycle on a mismatched formulation costs you a batch, and you rarely find out until reconstitution. Fixing it at the formulation stage costs a fraction of what fixing it at pilot scale does.',
                'icon' => 'bi-flask',
                'image' => $this->demoImage('demo/why-choose/cycle-expertise.jpg', 'Formulation-first lyophilization', 'Formulation-first'),
                'sort_order' => 1,
            ],
            [
                'title' => 'Pilot-scale is our scale, not a stretch',
                'description' => 'We deliberately stay at the pilot batch level. That means your project isn\'t the smallest thing on the floor, and it isn\'t being fitted around a commercial run. If your product has outgrown pilot volumes, we\'ll help you scope what a scale-up partner needs from the work we\'ve already done together.',
                'icon' => 'bi-bounding-box',
                'image' => $this->demoImage('demo/why-choose/pilot-scale.jpg', 'Pilot-scale lyophilization', 'Pilot-scale focus'),
                'sort_order' => 2,
            ],
            [
                'title' => 'Documentation the next manufacturer will accept',
                'description' => 'Batch records, cycle parameters, and process notes are structured for technology transfer from day one — because in this industry, "we lyophilized it and it looked fine" is not a handoff. Every project we take on is designed to move cleanly to whoever manufactures it next.',
                'icon' => 'bi-file-earmark-text',
                'image' => $this->demoImage('demo/why-choose/documentation.jpg', 'Technology transfer documentation', 'Documentation'),
                'sort_order' => 3,
            ],
            [
                'title' => 'One point of contact, plain answers',
                'description' => 'You\'ll speak to the same person from feasibility through delivery. When we can\'t help — or when your regulatory needs sit outside our quality tier — we\'ll say so up front. Straightforward communication isn\'t a marketing line for us; it\'s how we keep projects on schedule.',
                'icon' => 'bi-people',
                'image' => $this->demoImage('demo/why-choose/collaboration.jpg', 'Direct technical collaboration', 'Plain answers'),
                'sort_order' => 4,
            ],
        ];

        foreach ($items as $item) {
            WhyChooseItem::query()->create(array_merge($item, ['status' => true]));
        }
    }
}
