<?php

namespace App\Support;

class ThemePageDefaults
{
    public static function serviceExtra(string $slug): array
    {
        return match ($slug) {
            'formulation-lyo-cycle-development' => self::formulationExtra(),
            'pilot-batch-vial-lyophilization' => self::pilotBatchExtra(),
            'scale-up-technology-transfer' => self::scaleUpExtra(),
            default => self::emptyServiceExtra(),
        };
    }

    public static function qualityExtra(): array
    {
        return [
            'hero_eyebrow' => 'Quality & Compliance',
            'hero_sub' => 'We\'d rather tell you upfront what our quality level covers, and what it doesn\'t, than have it come up as a surprise halfway through your project.',
            'approach_eyebrow' => 'Our Quality Approach',
            'approach_heading' => 'Built for Pilot-Scale, R&D-Oriented Production',
            'approach_cards' => [
                [
                    'title' => 'ISO 13485-Aligned Processes',
                    'body' => 'Our quality processes are built around ISO 13485 principles, applied at a scale that fits pilot and feasibility work.',
                ],
                [
                    'title' => 'Pilot-Scale, R&D-Built Facility',
                    'body' => 'Our equipment and processes are designed for feasibility, pilot, and early-stage production — not high-volume commercial manufacturing.',
                ],
            ],
            'sterility_heading' => 'Sterility Testing, Done Transparently',
            'sterility_body' => 'Our lyophilization process isn\'t formally validated for sterility assurance on its own. What we offer instead: on request, a completed batch is sent to an independent, accredited third-party laboratory for sterility testing — with results shared with you directly, batch by batch.',
            'fit_eyebrow' => 'What This Means for Your Project',
            'fit_heading' => 'Is Our Quality Level Right for What You\'re Building?',
            'fit_yes_heading' => 'Well Suited To',
            'fit_yes' => [
                'Research Use Only (RUO) reagents and components',
                'Calibrators, controls, and media supplements for lab use',
                'Cosmetic actives and formulations',
                'Feasibility and pilot batches ahead of a GMP scale-up decision',
            ],
            'fit_no_heading' => 'Not a Substitute For',
            'fit_no' => [
                'GMP-certified sterile manufacturing',
                'Health Canada / FDA-licensed drug product production',
                'High-volume commercial manufacturing',
                'Formal sterility-assurance validation',
            ],
            'quote' => 'We\'d rather lose a project by being upfront about our quality level than win one by being vague about it.',
            'quote_label' => 'Our Approach to Every New Project',
            'cta_heading' => 'Not sure if your project fits our quality level?',
            'cta_body' => 'Tell us what you\'re building and what it needs to comply with — we\'ll tell you plainly if we\'re the right fit.',
            'cta_button' => 'Ask Us Directly',
        ];
    }

    public static function specimenExtra(): array
    {
        return [
            'hero_eyebrow' => 'Specimen Library Preservation',
            'hero_sub' => 'We convert biospecimens from an existing frozen collection into a lyophilized, room-temperature-stable format — reducing freezer dependency while preserving the nucleic acids, proteins, and other analytes your research depends on.',
            'hero_button' => 'Talk to Us About Your Collection',
            'benefits' => [
                ['title' => 'No Cold-Chain Shipping'],
                ['title' => 'Lower Storage Cost'],
                ['title' => 'Freezer-Failure-Proof'],
                ['title' => 'Long-Term Shelf Stability'],
            ],
            'challenge_eyebrow' => 'The Challenge',
            'challenge_heading' => 'Frozen Libraries Carry a Quiet, Growing Risk',
            'challenge_body' => 'Every specimen library sitting in a −80°C freezer depends on one thing never failing — the freezer. A single compressor failure, a power cut, or years of routine freeze-thaw cycling during access can degrade or destroy specimens that took years to collect and can\'t be replaced. Cold storage also means ongoing electricity draw, backup generator commitments, and courier logistics that only get more expensive as a collection grows.',
            'solution_eyebrow' => 'The Solution',
            'solution_heading' => 'A Lyophilization Path for Existing Collections',
            'solution_steps' => [
                [
                    'label' => 'Step 1',
                    'title' => 'Collection Assessment',
                    'body' => 'We review a representative set of samples from your library to understand analyte type, current storage condition, and what needs to be preserved through drying.',
                ],
                [
                    'label' => 'Step 2',
                    'title' => 'Small-Batch Conversion Run',
                    'body' => 'A pilot batch is lyophilized and tested for recovery, so you can confirm the dried format holds up before committing the full collection.',
                ],
                [
                    'label' => 'Step 3',
                    'title' => 'Migration & Long-Term Storage Format',
                    'body' => 'Confirmed specimens are converted in batches, each one documented, and returned to you in a stable, room-temperature-ready format.',
                ],
            ],
            'stats' => [
                'No Dry Ice Required for Shipping',
                'Room-Temperature Shelf Stability',
                'Documented Per-Batch Recovery Data',
                'Freed-Up Freezer Capacity',
            ],
            'faq_eyebrow' => 'Common Questions',
            'faq_heading' => 'Before You Convert a Collection',
            'faqs' => [
                [
                    'question' => 'Will lyophilization change what I can test for later?',
                    'answer' => 'It depends on the analyte. We test recovery on your specific sample type during the pilot conversion run, so you know exactly what holds up before the full collection is converted.',
                ],
                [
                    'question' => 'Can I convert only part of my collection?',
                    'answer' => 'Yes. Most projects start with a pilot batch, then move to full migration in stages as results are confirmed — you don\'t need to commit the whole library upfront.',
                ],
                [
                    'question' => 'What happens to the original frozen specimens?',
                    'answer' => 'That\'s your call. Some clients retain frozen originals in reduced cold storage as a backup; others retire them once the lyophilized format is validated.',
                ],
            ],
            'cta_heading' => 'Have a specimen library sitting in the freezer?',
            'cta_body' => 'Tell us the sample type, collection size, and what you\'d want to test for after conversion.',
            'cta_button' => 'Request a Consultation',
        ];
    }

    public static function mergeService(?array $extra, string $slug): array
    {
        return array_replace_recursive(self::serviceExtra($slug), $extra ?? []);
    }

    public static function mergePage(?array $extra, string $type): array
    {
        $defaults = match ($type) {
            'quality_compliance' => self::qualityExtra(),
            'specimen_library' => self::specimenExtra(),
            'partnerships' => self::partnershipsExtra(),
            default => [],
        };

        return array_replace_recursive($defaults, $extra ?? []);
    }

    public static function partnershipsExtra(): array
    {
        return [
            'hero_eyebrow' => 'Partnerships',
            'hero_heading' => 'Two partners we route real work through',
            'hero_accent' => 'real work',
            'hero_lede' => 'LyoVial works alongside two partner organizations to extend what we can offer to our US clients directly: freeze-dried reagent production with US-based distribution, RUO active peptide wholesale, and independent analytical testing.',
            'partners' => [
                [
                    'num' => '01',
                    'name' => 'Lyolab Diagnostics',
                    'location' => 'Columbia, MO',
                    'title' => 'Freeze-dried reagent manufacturing & RUO peptide wholesale',
                    'summary' => 'Contract manufacturing with lyophilized vial fill and finish, plus bulk RUO active peptide supply for labs, CROs, and diagnostic developers.',
                    'logo' => '/images/site/partner-lyolab.png',
                    'anchor' => 'lyolab',
                    'website' => 'https://www.lyolabdiagnostics.com/',
                    'sections' => [
                        [
                            'heading' => 'Freeze-dried reagent contract manufacturing',
                            'body' => 'Lyolab Diagnostics specializes in freeze-dried reagent contract manufacturing, including lyophilized vial fill and finish — the step where formulation becomes a stable, shippable product.',
                        ],
                        [
                            'heading' => 'RUO active peptides wholesale',
                            'body' => 'Beyond contract manufacturing, Lyolab supplies research-use-only active peptides at bulk and wholesale volume for laboratory and research customers, from single labs to CROs and diagnostic developers sourcing material at scale.',
                        ],
                    ],
                    'callout_label' => 'Intended use',
                    'callout_body' => 'All RUO peptide material is supplied strictly for laboratory research use. It is not intended for human or veterinary use, diagnostic use, or any clinical application.',
                    'bullets' => [
                        'Wholesale and bulk RUO peptide supply in vials',
                        'Research-use-only active peptides for laboratory customers',
                        'Sourcing for labs, CROs, and diagnostic developers needing volume pricing',
                    ],
                    'methods' => [],
                ],
                [
                    'num' => '02',
                    'name' => 'Vanguard Analytical',
                    'location' => 'Independent lab',
                    'title' => 'Independent analytical testing with CoA reporting',
                    'summary' => 'HPLC purity analysis, mass spectrometry, and endotoxin testing — third-party verification alongside your lyophilization project.',
                    'logo' => '/images/site/partner-vanguard.webp',
                    'anchor' => 'vanguard',
                    'website' => 'https://vanguardanalytical.com/',
                    'sections' => [
                        [
                            'heading' => 'Independent analytical testing',
                            'body' => 'Vanguard Analytical provides independent analytical testing services with Certificate of Analysis reporting. This partnership gives LyoVial clients access to independent, third-party testing alongside their lyophilization project.',
                        ],
                    ],
                    'callout_label' => '',
                    'callout_body' => '',
                    'bullets' => [],
                    'methods' => [
                        ['name' => 'HPLC purity analysis', 'desc' => 'Quantifies purity and detects related impurities.'],
                        ['name' => 'Mass spectrometry', 'desc' => 'Confirms molecular identity.'],
                        ['name' => 'Endotoxin testing', 'desc' => 'Screens for bacterial endotoxin contamination.'],
                        ['name' => 'Certificate of Analysis', 'desc' => 'Documented, per-lot reporting of results.'],
                    ],
                ],
            ],
            'cta_heading' => 'Tell us what your project needs.',
            'cta_body' => 'Whether you need a pilot batch produced, wholesale RUO peptide material sourced, or independent analytical testing arranged, get in touch and we\'ll route it to the right partner.',
            'cta_button' => 'Get In Touch',
            'cta_paths' => [
                ['tag' => 'Pilot batch', 'text' => 'Produced in-house at LyoVial'],
                ['tag' => 'Wholesale RUO', 'text' => 'Sourced through Lyolab Diagnostics'],
                ['tag' => 'Independent testing', 'text' => 'Arranged through Vanguard Analytical'],
            ],
        ];
    }

    protected static function emptyServiceExtra(): array
    {
        return [
            'eyebrow' => '',
            'intro_heading' => '',
            'includes_heading' => '',
            'includes' => [],
            'why_heading' => '',
            'why_bullets' => [],
            'steps_heading' => '',
            'steps_intro' => '',
            'steps' => [],
            'related_heading' => '',
            'sidebar_cta_title' => '',
            'sidebar_cta_body' => '',
            'sidebar_cta_button' => '',
            'bottom_cta_heading' => '',
            'bottom_cta_body' => '',
            'bottom_cta_button' => '',
        ];
    }

    protected static function formulationExtra(): array
    {
        return [
            'eyebrow' => 'Our Core Service',
            'intro_heading' => 'Turning Your Formulation Into a Locked, Reproducible Freeze-Drying Cycle',
            'includes_heading' => 'What This Service Includes',
            'includes' => [
                [
                    'title' => 'Formulation Review & Excipient Selection',
                    'body' => 'We review your current formulation and select excipients and cryoprotectants suited to your product and target shelf life.',
                ],
                [
                    'title' => 'Freeze-Thaw & Thermal Characterization',
                    'body' => 'We characterize your formulation\'s thermal behavior to understand collapse temperature before cycle design begins.',
                ],
                [
                    'title' => 'Cycle Design — Freezing, Primary & Secondary Drying',
                    'body' => 'We build a step-by-step freeze-drying cycle covering freezing, primary drying, and secondary drying stages.',
                ],
                [
                    'title' => 'Feasibility Runs Before Lock-In',
                    'body' => 'Small trial runs confirm cake appearance, reconstitution, and stability before we commit to a final, locked process.',
                ],
            ],
            'why_heading' => 'Why This Matters for Your Product',
            'why_bullets' => [
                'A locked cycle means your batches behave the same way every time — no re-work at pilot scale.',
                'Documentation at every stage means your process is ready for technology transfer, not stuck in someone\'s head.',
                'You get one point of contact from feasibility through delivery — and plain answers on where our quality level fits your regulatory needs.',
            ],
            'steps_heading' => 'How It Works',
            'steps_intro' => 'Four stages, from your first sample to a documented, pilot-ready process.',
            'steps' => [
                [
                    'num' => '01',
                    'title' => 'Formulation Review',
                    'body' => 'Assess or build your formulation from scratch.',
                ],
                [
                    'num' => '02',
                    'title' => 'Cycle Development',
                    'body' => 'Thermal characterization and drying parameters.',
                ],
                [
                    'num' => '03',
                    'title' => 'Feasibility Run',
                    'body' => 'Small trial confirms cake, reconstitution, stability.',
                ],
                [
                    'num' => '04',
                    'title' => 'Locked Process',
                    'body' => 'Documented cycle ready for pilot-batch production.',
                ],
            ],
            'related_heading' => 'Related Services',
            'sidebar_cta_title' => 'Need a Custom Formulation?',
            'sidebar_cta_body' => 'Tell us your formulation, target batch size, and timeline — we\'ll scope it for you.',
            'sidebar_cta_button' => 'Request a Quote',
            'bottom_cta_heading' => 'Ready to talk about your formulation?',
            'bottom_cta_body' => 'Send us your target batch size and timeline — we\'ll get back to you within one business day.',
            'bottom_cta_button' => 'Request a Quote',
        ];
    }

    protected static function pilotBatchExtra(): array
    {
        return [
            'eyebrow' => 'Our Core Service',
            'intro_heading' => 'Small-Batch, Documented Lyophilization in Glass Vials',
            'includes_heading' => 'What This Service Includes',
            'includes' => [
                [
                    'title' => 'Vial Format Selection',
                    'body' => 'We match glass vial size and format to your product, fill volume, and downstream use.',
                ],
                [
                    'title' => 'Small & Mid-Size Batch Runs',
                    'body' => 'Batches sized for R&D quantities, validation studies, and launch-stage supply — not full commercial volumes.',
                ],
                [
                    'title' => 'Run-to-Run Consistency',
                    'body' => 'Every batch follows the same locked cycle and is checked against the same specifications, so results don\'t drift between runs.',
                ],
                [
                    'title' => 'Batch-Level Testing on Request',
                    'body' => 'A completed batch can be sent to an independent, accredited lab for sterility or other testing, with results shared directly with you.',
                ],
            ],
            'why_heading' => 'Why This Matters for Your Project',
            'why_bullets' => [
                'You get production-ready vials without building or staffing an in-house freeze-dryer.',
                'Small batch sizes mean less product tied up in a single run — useful for validation and early-launch stages.',
                'Every run is documented, so a batch made this month behaves the same as one made next quarter.',
            ],
            'steps_heading' => 'How It Works',
            'steps_intro' => 'Four stages, from a locked cycle to vials ready for delivery.',
            'steps' => [
                [
                    'num' => '01',
                    'title' => 'Confirm the Cycle',
                    'body' => 'Start from your locked formulation and cycle.',
                ],
                [
                    'num' => '02',
                    'title' => 'Select Vial Format',
                    'body' => 'Glass vial size and fill volume matched to your product.',
                ],
                [
                    'num' => '03',
                    'title' => 'Run the Batch',
                    'body' => 'Small or mid-size batch processed under the locked cycle.',
                ],
                [
                    'num' => '04',
                    'title' => 'Deliver & Document',
                    'body' => 'Batch records delivered with your product.',
                ],
            ],
            'related_heading' => 'Related Services',
            'sidebar_cta_title' => 'Planning a Pilot Batch?',
            'sidebar_cta_body' => 'Tell us your vial format, target batch size, and timeline — we\'ll scope it for you.',
            'sidebar_cta_button' => 'Request a Quote',
            'bottom_cta_heading' => 'Ready to move to pilot-batch production?',
            'bottom_cta_body' => 'Tell us your target batch size and vial format — we\'ll walk you through timelines and next steps.',
            'bottom_cta_button' => 'Request a Quote',
        ];
    }

    protected static function scaleUpExtra(): array
    {
        return [
            'eyebrow' => 'Our Core Service',
            'intro_heading' => 'Moving Your Cycle From Feasibility Runs to Pilot-Batch Scale',
            'includes_heading' => 'What This Service Includes',
            'includes' => [
                [
                    'title' => 'Scale-Up Planning',
                    'body' => 'We map how your feasibility-scale cycle needs to change, if at all, as batch size increases.',
                ],
                [
                    'title' => 'Parameter Documentation at Each Scale',
                    'body' => 'Every freezing, drying, and hold-time parameter is recorded as the batch size grows.',
                ],
                [
                    'title' => 'Support Through the Transition',
                    'body' => 'We stay involved through the move from feasibility to pilot scale, flagging anything that needs adjustment.',
                ],
            ],
            'why_heading' => 'Why This Matters for Your Project',
            'why_bullets' => [
                'A cycle that works in five vials doesn\'t always behave the same in five hundred — we catch that gap before it becomes a problem.',
                'You keep the same point of contact through the entire scale-up, not a hand-off to someone new partway through.',
            ],
            'steps_heading' => 'How It Works',
            'steps_intro' => 'Three stages, from feasibility data to a documented pilot batch.',
            'steps' => [
                [
                    'num' => '01',
                    'title' => 'Review Feasibility Data',
                    'body' => 'Start from your feasibility-scale cycle and results.',
                ],
                [
                    'num' => '02',
                    'title' => 'Plan the Scale-Up',
                    'body' => 'Identify what changes, if anything, at pilot-batch size.',
                ],
                [
                    'num' => '03',
                    'title' => 'Run the Pilot Batch',
                    'body' => 'Execute and document the scaled process.',
                ],
            ],
            'related_heading' => 'Related Services',
            'sidebar_cta_title' => 'Ready to Scale Up?',
            'sidebar_cta_body' => 'Tell us where your process stands today and where it needs to go — we\'ll map the path.',
            'sidebar_cta_button' => 'Request a Quote',
            'bottom_cta_heading' => 'Ready to scale up your cycle?',
            'bottom_cta_body' => 'Tell us where your process stands today and where it needs to go — we\'ll map the path.',
            'bottom_cta_button' => 'Request a Quote',
        ];
    }
}
