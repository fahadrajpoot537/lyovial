<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Service;
use App\Support\ThemePageDefaults;
use Illuminate\Database\Seeder;

class ThemePageContentSeeder extends Seeder
{
    public function run(): void
    {
        $leads = [
            'formulation-lyo-cycle-development' => 'We work from your existing liquid formulation, or help you build one from scratch, and design a freeze-drying cycle around it. Every stage — from excipient selection to a final, reproducible process — is documented, so it transfers cleanly to your own operation or your next-stage manufacturer.',
            'pilot-batch-vial-lyophilization' => 'Once your formulation and cycle are locked, we scale production into glass vials — sized for R&D use, validation studies, product launches, and early commercial supply, without the commitment of large-scale manufacturing.',
            'scale-up-technology-transfer' => 'Once a cycle is set at feasibility scale, we scale it up to pilot-batch size. Every parameter is documented as it moves from a handful of vials to a full pilot run, so the process transfers cleanly to your own production line or to a larger manufacturer later.',
        ];

        foreach ($leads as $slug => $lead) {
            $service = Service::query()->where('slug', $slug)->first();
            if (! $service) {
                continue;
            }

            $service->update([
                'short_description' => $lead,
                'extra' => ThemePageDefaults::serviceExtra($slug),
                'button_text' => $service->button_text ?: 'Request a Quote',
                'button_link' => $service->button_link ?: '/contact',
                'page_heading' => $service->page_heading ?: $service->title,
            ]);
        }

        $quality = Page::query()->ofType(Page::TYPE_QUALITY_COMPLIANCE)->first();
        if ($quality) {
            $quality->update([
                'heading' => $quality->heading ?: 'Where We Stand on Quality — Before It Becomes a Surprise',
                'extra' => ThemePageDefaults::qualityExtra(),
            ]);
        }

        $specimen = Page::query()->ofType(Page::TYPE_SPECIMEN_LIBRARY)->first();
        if ($specimen) {
            $specimen->update([
                'heading' => $specimen->heading ?: 'Move Your Specimen Library Off the Freezer, Without Losing the Sample',
                'extra' => ThemePageDefaults::specimenExtra(),
            ]);
        }
    }
}
