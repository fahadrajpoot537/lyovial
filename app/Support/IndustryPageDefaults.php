<?php

namespace App\Support;

class IndustryPageDefaults
{
    public static function merge(?array $extra, string $slug): array
    {
        return array_replace_recursive(self::forSlug($slug), $extra ?? []);
    }

    public static function navTitle(?array $extra, string $slug, string $fallback): string
    {
        $merged = self::merge($extra, $slug);

        return $merged['nav_title'] ?? $fallback;
    }

    public static function forSlug(string $slug): array
    {
        return match ($slug) {
            'diagnostic-assay-reagent-manufacturers' => self::diagnostics(),
            'calibrator-control-producers' => self::calibrators(),
            'microbiology-media-supplement-suppliers' => self::microbiology(),
            'analytical-testing-laboratories' => self::analytical(),
            'university-institutional-rd-groups' => self::research(),
            'cosmetic-ingredient-formulators' => self::cosmetics(),
            default => self::empty(),
        };
    }

    protected static function process(string $eyebrow): array
    {
        return [
            'process_eyebrow' => $eyebrow,
            'process_heading' => 'From feasibility conversation to documented pilot batch',
            'process_intro' => 'Each stage is signed off before the next begins, so you always know what\'s locked and what the next manufacturer will receive.',
            'steps' => [
                ['title' => 'Feasibility & consultation', 'body' => 'We review your material, target format, and requirements, then say plainly whether we\'re a fit.'],
                ['title' => 'Formulation & excipients', 'body' => 'Cryoprotectant screening and thermal characterization so the product holds through drying and storage.'],
                ['title' => 'Lyo cycle development', 'body' => 'A reproducible cycle built around your formulation, verified against your acceptance targets.'],
                ['title' => 'Pilot vial batches', 'body' => 'Documented pilot production in glass vials, with batch records structured for technology transfer.'],
            ],
        ];
    }

    protected static function whyItems(string $specialty): array
    {
        return [
            '<b>Specialists, not a generalist CDMO</b> — freeze-drying for '.$specialty.' is what our group is built around.',
            '<b>Pilot-scale is our scale</b> — your project isn\'t the smallest thing on the floor.',
            '<b>Documentation that transfers</b> — batch records the next manufacturer accepts without questions.',
        ];
    }

    protected static function empty(): array
    {
        return array_merge([
            'nav_title' => '',
            'hero_eyebrow' => 'Industry',
            'hero_h1' => '',
            'hero_lede' => '',
            'spec_heading' => 'Formats we freeze-dry',
            'spec_items' => [],
            'lead_eyebrow' => '',
            'lead_heading' => '',
            'lead_paras' => [],
            'needs_eyebrow' => 'What we support',
            'needs' => [],
            'related_intro' => 'A program usually touches all three of our capabilities.',
            'why_heading' => 'Why LyoVial',
            'why_body' => '',
            'why_items' => self::whyItems('your application'),
            'faq_heading' => 'Common questions',
            'faqs' => [],
            'cta_heading' => 'Ready to talk?',
            'cta_body' => 'Share your product goals and our Kanata team will help map the next step.',
            'cta_button' => 'Request a Feasibility Quote →',
        ], self::process('How a program runs'));
    }

    protected static function diagnostics(): array
    {
        return array_merge([
            'nav_title' => 'Diagnostic Assay Reagents',
            'hero_eyebrow' => 'Industry · In-Vitro Diagnostics',
            'hero_h1' => 'Diagnostic reagent <em>lyophilization,</em> built to hold through scale-up',
            'hero_lede' => 'Freeze-dried enzymes, oligos, and detection reagents for IVD kits and lateral-flow assays — cycle development and pilot vial batches, documented to transfer cleanly.',
            'spec_heading' => 'Reagent formats we freeze-dry',
            'spec_items' => [
                ['title' => 'Enzymes', 'body' => 'polymerases, reverse transcriptases, ligases in glycerol-free formats'],
                ['title' => 'Oligonucleotides', 'body' => 'primers, probes, master-mix components'],
                ['title' => 'Detection reagents', 'body' => 'antibodies, conjugates, substrates'],
                ['title' => 'Complete assay mixes', 'body' => 'single-vial, add-sample-and-go'],
            ],
            'lead_eyebrow' => 'Why diagnostics teams lyophilize',
            'lead_heading' => 'The reagent has to survive shipping, storage, and the bench — not just the freeze-dryer',
            'lead_paras' => [
                'Diagnostic assay developers rely on lyophilization to protect sensitive reagents from hydrolysis, temperature excursions, and cold-chain logistics. A freeze-dried reagent ships at ambient temperature, reconstitutes in one step, and holds its performance across a long shelf life.',
                'But a diagnostic reagent is unforgiving: a collapsed cake, a cycle that denatures an enzyme, or reconstitution that drifts lot-to-lot all show up as assay failures — usually long after the batch is made. We develop freeze-drying approaches that preserve analytical performance from the first feasibility run onward.',
            ],
            'needs_eyebrow' => 'What we support',
            'needs' => [
                ['n' => '01', 'title' => 'Liquid → lyophilized conversion', 'body' => 'Reformulating a wet reagent into a stable freeze-dried format — excipient and cryoprotectant selection matched to your enzyme or conjugate chemistry.'],
                ['n' => '02', 'title' => 'Cake integrity & reconstitution', 'body' => 'Locking a cycle that produces a uniform cake and dissolves the same way every time — the line between a passing and failing assay.'],
                ['n' => '03', 'title' => 'Pilot lots for kit assembly', 'body' => 'Vial batches sized for verification, validation studies, and early commercial supply — without a large CDMO\'s minimums.'],
            ],
            'related_intro' => 'A reagent program usually touches all three of our capabilities.',
            'why_heading' => 'Formulation-first — because a bad cycle costs you a batch',
            'why_body' => 'Most freeze-drying services will run whatever cycle you hand them. We start with the reagent formulation, because fixing a mismatch there costs a fraction of finding it at reconstitution.',
            'why_items' => self::whyItems('diagnostics'),
            'faq_heading' => 'Diagnostic reagent freeze-drying, answered plainly',
            'faqs' => [
                ['q' => 'Can you lyophilize enzymes without glycerol?', 'a' => 'Yes. Glycerol interferes with freeze-drying, so much of reagent lyophilization is reformulating into glycerol-free, lyo-compatible chemistry that still protects enzyme activity through the cycle and on reconstitution.'],
                ['q' => 'Do you make single-vial "add-sample-and-go" reagents?', 'a' => 'That\'s a common target. Once formulation and cycle are locked, complete master-mix components can be freeze-dried together in one vial so the end user just reconstitutes and runs.'],
                ['q' => 'What batch sizes do you handle for diagnostics?', 'a' => 'We focus on pilot-scale vial lyophilization — the step between benchtop development and commercial manufacturing. Tell us your target batch size and we\'ll confirm fit on the first call.'],
                ['q' => 'Do you handle GMP diagnostic reagent work?', 'a' => 'We operate quality-minded, documented workflows suited to diagnostic development. If your project needs a specific GMP tier beyond our scope, we\'ll say so plainly and structure documentation to transfer cleanly to a GMP manufacturer.'],
                ['q' => 'Will the cycle survive scale-up?', 'a' => 'That\'s the point of developing it formulation-first and documenting every parameter. We build the cycle to hold when it moves to your line or a larger manufacturer.'],
            ],
            'cta_heading' => 'Tell us about your diagnostic reagent',
            'cta_body' => 'Share your formulation, target format, and assay requirements. Our Kanata team will tell you plainly whether freeze-drying is the right path — and map the next step.',
            'cta_button' => 'Request a Feasibility Quote →',
        ], self::process('How a reagent program runs'));
    }

    protected static function calibrators(): array
    {
        return array_merge([
            'nav_title' => 'Calibrator & Control Producers',
            'hero_eyebrow' => 'Industry · Quality-Control Materials',
            'hero_h1' => 'Calibrator and control <em>lyophilization</em> with values that hold',
            'hero_lede' => 'Freeze-dried calibrators, controls, and QC materials with reproducible reconstitution and stable value assignment across a long shelf life — developed and documented in vial format.',
            'spec_heading' => 'QC materials we freeze-dry',
            'spec_items' => [
                ['title' => 'Calibrators', 'body' => 'single- and multi-analyte, value-assigned'],
                ['title' => 'Quality controls', 'body' => 'normal and pathological levels'],
                ['title' => 'Reference materials', 'body' => 'traceable, characterised'],
                ['title' => 'QC panels', 'body' => 'matched sets across concentration ranges'],
            ],
            'lead_eyebrow' => 'Why QC producers lyophilize',
            'lead_heading' => 'For a control material, the number on the vial is the product — the cycle can\'t move it',
            'lead_paras' => [
                'Calibrators and controls only work if their assigned values stay put. Lyophilization gives QC producers the ambient-stable, long-shelf-life format the market expects, but every step of the cycle is a chance to shift an analyte, break commutability, or introduce vial-to-vial variation.',
                'We treat value stability and reconstitution accuracy as the acceptance criteria, not an afterthought. The goal is a cake that reconstitutes to the same value in every vial, in every lot — so your value-assignment work survives the freeze-dryer instead of being redone after it.',
            ],
            'needs_eyebrow' => 'What we support',
            'needs' => [
                ['n' => '01', 'title' => 'Value-stable formulation', 'body' => 'Excipient and matrix choices that protect labile analytes so assigned values hold through drying, storage, and reconstitution.'],
                ['n' => '02', 'title' => 'Vial-to-vial uniformity', 'body' => 'Fill and cycle control that keeps concentration consistent across the batch — critical for a material used to judge other assays.'],
                ['n' => '03', 'title' => 'Reconstitution accuracy', 'body' => 'A cake that dissolves fully to a defined volume, so the end user recovers the assigned value without technique-dependent error.'],
            ],
            'related_intro' => 'A calibrator program usually touches all three of our capabilities.',
            'why_heading' => 'We protect the value assignment, not just the cake',
            'why_body' => 'A general freeze-drying run can produce a good-looking cake that still recovers the wrong number. We build the formulation and cycle around value stability and commutability from the first trial.',
            'why_items' => self::whyItems('control materials'),
            'faq_heading' => 'Calibrator & control freeze-drying, answered plainly',
            'faqs' => [
                ['q' => 'Will lyophilization shift my assigned values?', 'a' => 'It can, if the formulation isn\'t built for it — which is exactly what we develop against. We screen excipients and cycle parameters to protect labile analytes so recovered values stay within your acceptance range.'],
                ['q' => 'Can you handle multi-analyte panels?', 'a' => 'Yes. Multi-analyte calibrators and controls are common work; the challenge is a single matrix and cycle that keep every analyte stable at once, which we address at the formulation stage.'],
                ['q' => 'How do you keep vials consistent across a lot?', 'a' => 'Through controlled fill and a validated cycle. For a material that judges other assays, vial-to-vial uniformity is a primary acceptance criterion, not a nice-to-have.'],
                ['q' => 'What shelf life can we expect?', 'a' => 'That depends on the analytes and matrix. We characterise the formulation up front and structure the work so stability studies can support the shelf-life claim you need.'],
                ['q' => 'Do you support commutability requirements?', 'a' => 'We develop with commutability in mind and document the process so it transfers to your production. Formal commutability studies sit with your validation, but the freeze-drying won\'t be what breaks it.'],
            ],
            'cta_heading' => 'Tell us about your control material',
            'cta_body' => 'Share your analytes, target levels, and stability goals. We\'ll tell you plainly whether the values will hold in a freeze-dried format — and how we\'d get there.',
            'cta_button' => 'Request a Feasibility Quote →',
        ], self::process('How a calibrator program runs'));
    }

    protected static function microbiology(): array
    {
        return array_merge([
            'nav_title' => 'Microbiology Media & Supplements',
            'hero_eyebrow' => 'Industry · Microbiology',
            'hero_h1' => 'Microbiology media <em>freeze-drying</em> that rehydrates ready to work',
            'hero_lede' => 'Freeze-dried culture media, supplements, and enrichment components in vial format — developed so they rehydrate cleanly and perform the way the wet product did.',
            'spec_heading' => 'Media components we freeze-dry',
            'spec_items' => [
                ['title' => 'Culture media', 'body' => 'broths and defined formulations'],
                ['title' => 'Supplements', 'body' => 'growth factors, selective agents'],
                ['title' => 'Enrichment components', 'body' => 'single-use, vial-format'],
                ['title' => 'Heat-sensitive additives', 'body' => 'dried without a cook step'],
            ],
            'lead_eyebrow' => 'Why media suppliers lyophilize',
            'lead_heading' => 'The test isn\'t a dry cake — it\'s what grows after rehydration',
            'lead_paras' => [
                'Freeze-drying lets media and supplement suppliers ship ambient-stable, single-use vials instead of refrigerated liquid, cutting cold-chain cost and waste. It\'s ideal for heat-sensitive components that can\'t survive autoclaving, and for pre-measured formats that remove prep error in the end user\'s lab.',
                'But microbiology media is judged on performance after rehydration — growth support, selectivity, and consistency. A cycle that\'s too aggressive can damage a labile supplement or shift a formulation\'s behaviour. We develop cycles that keep the rehydrated product performing to spec, batch after batch.',
            ],
            'needs_eyebrow' => 'What we support',
            'needs' => [
                ['n' => '01', 'title' => 'Performance-preserving cycles', 'body' => 'Drying parameters gentle enough to protect labile supplements and growth factors, so the rehydrated medium performs as intended.'],
                ['n' => '02', 'title' => 'Clean, complete rehydration', 'body' => 'A cake that dissolves fully with the intended volume — no residue, no technique-dependent variation at the bench.'],
                ['n' => '03', 'title' => 'Single-use vial formats', 'body' => 'Pre-measured, ambient-stable vials that remove prep steps and cold-chain from the end user\'s workflow.'],
            ],
            'related_intro' => 'A media program usually touches all three of our capabilities.',
            'why_heading' => 'We develop to the rehydrated result, not the dry appearance',
            'why_body' => 'A good-looking cake means nothing if the medium underperforms after rehydration. We build the cycle around growth support and consistency, and tell you plainly what a labile component can and can\'t survive.',
            'why_items' => self::whyItems('microbiology media'),
            'faq_heading' => 'Media & supplement freeze-drying, answered plainly',
            'faqs' => [
                ['q' => 'Will freeze-drying affect how my media performs?', 'a' => 'It can if the cycle is too aggressive for a labile component — which is what we develop against. We tune the cycle so the rehydrated medium meets your growth and selectivity spec.'],
                ['q' => 'Can you dry heat-sensitive supplements?', 'a' => 'Yes — that\'s often the whole reason to lyophilize rather than autoclave. Freeze-drying removes water without a heat step, and we set parameters to protect the sensitive components.'],
                ['q' => 'Do you fill single-use vial formats?', 'a' => 'Yes. Pre-measured, single-use vials are a common request because they remove prep error and cold-chain from the end user\'s lab.'],
                ['q' => 'How do you keep lots consistent?', 'a' => 'Through a locked, documented cycle and controlled fill, verified against your rehydration and performance criteria for each batch.'],
                ['q' => 'Can you help if we only have a liquid formulation?', 'a' => 'Yes. We work from your existing liquid formulation — or help adjust it — and develop the freeze-drying cycle around it.'],
            ],
            'cta_heading' => 'Tell us about your media or supplement',
            'cta_body' => 'Share your formulation and how it\'s judged after rehydration. We\'ll tell you plainly what freeze-drying can preserve — and how we\'d develop the cycle.',
            'cta_button' => 'Request a Feasibility Quote →',
        ], self::process('How a media program runs'));
    }

    protected static function analytical(): array
    {
        return array_merge([
            'nav_title' => 'Analytical Testing Laboratories',
            'hero_eyebrow' => 'Industry · Analytical Testing',
            'hero_h1' => 'Reference material <em>lyophilization</em> for testing-lab workflows',
            'hero_lede' => 'Freeze-dried reference materials, standards, and stabilized reagents — developed for homogeneity, stability, and reconstitution accuracy, with documentation testing labs can stand behind.',
            'spec_heading' => 'Standards we freeze-dry',
            'spec_items' => [
                ['title' => 'Reference materials', 'body' => 'characterised, traceable'],
                ['title' => 'Standards', 'body' => 'single- and multi-component'],
                ['title' => 'Stabilized reagents', 'body' => 'ambient-shippable'],
                ['title' => 'Proficiency-test samples', 'body' => 'homogeneous sets'],
            ],
            'lead_eyebrow' => 'Why testing labs lyophilize',
            'lead_heading' => 'A standard is only useful if every vial is the same vial',
            'lead_paras' => [
                'Analytical laboratories depend on reference materials and standards whose values don\'t drift. Lyophilization delivers the ambient-stable, long-shelf-life format that keeps a standard usable between orders and shippable without a cold chain — important for reagents and materials that degrade in solution.',
                'For this work, homogeneity across the batch and stability over time are everything: a standard that varies vial-to-vial, or shifts on the shelf, quietly undermines every result measured against it. We develop cycles that hold the value and keep the set uniform, with records that support traceability.',
            ],
            'needs_eyebrow' => 'What we support',
            'needs' => [
                ['n' => '01', 'title' => 'Batch homogeneity', 'body' => 'Fill and cycle control that keeps every vial in a set equivalent — the foundation of a usable reference material or PT sample.'],
                ['n' => '02', 'title' => 'Stability that holds the value', 'body' => 'Formulation and drying that protect labile components so the standard\'s value stays put through storage and shipping.'],
                ['n' => '03', 'title' => 'Accurate reconstitution', 'body' => 'A cake that dissolves fully to a defined volume, so recovered values are consistent regardless of who prepares it.'],
            ],
            'related_intro' => 'A reference-material program usually touches all three of our capabilities.',
            'why_heading' => 'We build for homogeneity and stability, not just a dry vial',
            'why_body' => 'A reference material that looks fine but varies across the set is worse than useless. We develop the cycle around uniformity and value stability, and document it so it stands up to scrutiny.',
            'why_items' => self::whyItems('reference materials'),
            'faq_heading' => 'Reference material freeze-drying, answered plainly',
            'faqs' => [
                ['q' => 'How do you ensure vials in a set are equivalent?', 'a' => 'Through controlled fill and a validated cycle, verified against homogeneity criteria. For standards and PT samples, batch homogeneity is a primary acceptance requirement.'],
                ['q' => 'Can you stabilise reagents that degrade in solution?', 'a' => 'Often yes — that\'s a core reason to lyophilize. We reformulate into a freeze-dried format that protects the labile component and ships at ambient temperature.'],
                ['q' => 'Do you handle small, custom batches?', 'a' => 'Yes. Pilot-scale is our focus, so custom and low-volume standard batches fit us better than they fit a large CDMO.'],
                ['q' => 'What documentation do we get?', 'a' => 'Batch records, cycle parameters, and process notes structured to support traceability and to transfer cleanly if you take production in-house or elsewhere.'],
                ['q' => 'Can you support stability studies?', 'a' => 'We characterise the formulation up front and structure the work so your stability studies can support the shelf-life and value claims you need.'],
            ],
            'cta_heading' => 'Tell us about your standard or reference material',
            'cta_body' => 'Share what you\'re stabilising and how it\'s used. We\'ll tell you plainly whether a freeze-dried format will hold homogeneous and stable — and how we\'d develop it.',
            'cta_button' => 'Request a Feasibility Quote →',
        ], self::process('How a reference-material program runs'));
    }

    protected static function research(): array
    {
        return array_merge([
            'nav_title' => 'University & Institutional R&D',
            'hero_eyebrow' => 'Industry · Academic & Institutional Research',
            'hero_h1' => 'Research sample <em>lyophilization</em> for labs without a lyo specialist',
            'hero_lede' => 'Freeze-drying for academic and hospital labs — biospecimen library preservation, one-off formulation work, and small research batches, handled by a specialist so your team doesn\'t have to become one.',
            'spec_heading' => 'Research work we freeze-dry',
            'spec_items' => [
                ['title' => 'Biospecimen libraries', 'body' => 'long-term preservation'],
                ['title' => 'Research samples', 'body' => 'proteins, reagents, extracts'],
                ['title' => 'One-off formulations', 'body' => 'single-project development'],
                ['title' => 'Small batches', 'body' => 'study- and grant-sized runs'],
            ],
            'lead_eyebrow' => 'Why research groups outsource lyo',
            'lead_heading' => 'You need the sample preserved — not a freeze-dryer to learn, buy, and maintain',
            'lead_paras' => [
                'University, hospital, and institutional labs often need lyophilization for a single project: preserving a biospecimen library, stabilising a protein or reagent, or drying samples for a study. Buying and validating a lyophilizer, then developing a cycle in-house, rarely makes sense for one-off or small-batch work on a grant timeline.',
                'We take that off your plate. Bring a formulation — or just a goal — and we\'ll develop the cycle, run the batch, and hand back a documented process. If your work falls outside our usual profiles, get in touch anyway; we\'ll tell you plainly whether we\'re a fit rather than fitting your project around a machine.',
            ],
            'needs_eyebrow' => 'What we support',
            'needs' => [
                ['n' => '01', 'title' => 'Biospecimen preservation', 'body' => 'Freeze-drying that stabilises specimen libraries for long-term, ambient-temperature storage without the freezer dependency.'],
                ['n' => '02', 'title' => 'One-off formulation work', 'body' => 'Cycle development for a single project — we build it from your material, even if you\'re starting from scratch.'],
                ['n' => '03', 'title' => 'Small, study-sized batches', 'body' => 'Pilot-scale runs sized to a study or grant, without a commercial-scale minimum or commitment.'],
            ],
            'related_intro' => 'A research program usually touches all three of our capabilities.',
            'why_heading' => 'Plain answers, realistic timelines, and no machine to buy',
            'why_body' => 'We\'re built for exactly the small, one-off work big CDMOs turn away. Bring the sample and the goal; we\'ll tell you what\'s feasible and hand back a process you can cite.',
            'why_items' => self::whyItems('research and diagnostic samples'),
            'faq_heading' => 'Research sample freeze-drying, answered plainly',
            'faqs' => [
                ['q' => 'Do you take on single-project or one-off work?', 'a' => 'Yes — that\'s much of what we do. One-off formulation and small-batch runs fit pilot-scale far better than they fit a large CDMO\'s minimums.'],
                ['q' => 'Can you work with very small quantities?', 'a' => 'Yes. We\'re set up for study- and grant-sized batches, so small volumes aren\'t a problem the way they are at commercial scale.'],
                ['q' => 'What if we don\'t have a formulation yet?', 'a' => 'Then we help build one. We can start from your material and goal and develop both the formulation and the freeze-drying cycle around it.'],
                ['q' => 'Can you preserve a biospecimen library?', 'a' => 'Yes. Freeze-drying stabilises specimen libraries for long-term ambient storage, reducing dependence on freezers and cold chain.'],
                ['q' => 'Can you work to a grant or study timeline?', 'a' => 'Tell us your deadline up front. We\'ll give you a realistic timeline once we understand the material, and flag early if it\'s tight.'],
            ],
            'cta_heading' => 'Tell us about your research sample',
            'cta_body' => 'Share your material and what you\'re trying to preserve or stabilise. We\'ll tell you plainly whether freeze-drying fits — and map a realistic timeline for your project.',
            'cta_button' => 'Request a Feasibility Quote →',
        ], self::process('How a research program runs'));
    }

    protected static function cosmetics(): array
    {
        return array_merge([
            'nav_title' => 'Cosmetic Ingredient Formulators',
            'hero_eyebrow' => 'Industry · Premium Cosmetics',
            'hero_h1' => 'Cosmetic active <em>lyophilization</em> that keeps the potency in the product',
            'hero_lede' => 'Freeze-dried cosmetic actives, single-dose beads, and stabilized botanicals for premium skincare — cycles developed to preserve peptide, protein, and botanical potency in an elegant format.',
            'spec_heading' => 'Cosmetic formats we freeze-dry',
            'spec_items' => [
                ['title' => 'Active ingredients', 'body' => 'peptides, proteins, enzymes'],
                ['title' => 'Single-dose beads', 'body' => 'uniform, activate-on-use'],
                ['title' => 'Stabilized botanicals', 'body' => 'extracts and actives'],
                ['title' => 'Preservative-free formats', 'body' => 'dry, water-activated'],
            ],
            'lead_eyebrow' => 'Why premium formulators lyophilize',
            'lead_heading' => 'A freeze-dried active sells on two things: potency and presentation',
            'lead_paras' => [
                'Premium skincare uses lyophilization to keep sensitive actives — peptides, proteins, enzymes, botanical extracts — potent right up to the moment of use. Removing water halts the degradation that quietly weakens a liquid active on the shelf, and enables preservative-free, water-activated formats the market increasingly expects.',
                'It\'s also a presentation story: a uniform single-dose bead or an elegant cake signals a premium product. We develop cycles that protect the active\'s potency and produce a consistent, attractive format — because in this category both the performance and the look have to be right.',
            ],
            'needs_eyebrow' => 'What we support',
            'needs' => [
                ['n' => '01', 'title' => 'Potency-preserving cycles', 'body' => 'Drying parameters tuned to protect labile peptides, proteins, and botanicals so the active is as strong at use as at fill.'],
                ['n' => '02', 'title' => 'Uniform single-dose beads', 'body' => 'Consistent bead format for lot-to-lot dosing and the premium, activate-on-use experience formulators want.'],
                ['n' => '03', 'title' => 'Preservative-free stability', 'body' => 'A dry, water-activated format that stays stable without the preservatives a liquid would need.'],
            ],
            'related_intro' => 'A cosmetic program usually touches all three of our capabilities.',
            'why_heading' => 'We develop for potency and presentation together',
            'why_body' => 'In premium cosmetics a dry cake isn\'t enough — the active has to stay potent and the format has to look right. We build the cycle around both, and tell you plainly what a delicate botanical can survive.',
            'why_items' => self::whyItems('specialty actives'),
            'faq_heading' => 'Cosmetic ingredient freeze-drying, answered plainly',
            'faqs' => [
                ['q' => 'Can you make single-dose beads?', 'a' => 'Yes. Lyophilized beads are a popular premium format — uniform, easy to dose lot-to-lot, and designed to activate when the user reconstitutes them.'],
                ['q' => 'Will freeze-drying preserve my active\'s potency?', 'a' => 'That\'s what the cycle is developed to protect. Removing water halts much of the degradation a liquid active suffers, and we tune parameters to safeguard labile peptides, proteins, and botanicals.'],
                ['q' => 'Can you dry delicate botanical extracts?', 'a' => 'Often yes. Botanicals vary, so we characterise the material first and tell you plainly what it can survive before committing to a cycle.'],
                ['q' => 'Do you support preservative-free formats?', 'a' => 'Yes — a dry, water-activated product can stay stable without the preservatives a liquid needs, which is a common reason to lyophilize a cosmetic active.'],
                ['q' => 'What batch sizes do you handle?', 'a' => 'We focus on pilot-scale vial lyophilization — well suited to R&D, validation, launches, and early commercial supply of premium actives without large minimums.'],
            ],
            'cta_heading' => 'Tell us about your cosmetic active',
            'cta_body' => 'Share your active and the format you\'re after. We\'ll tell you plainly what freeze-drying can preserve — and how we\'d develop the potency and the presentation together.',
            'cta_button' => 'Request a Feasibility Quote →',
        ], self::process('How a cosmetic program runs'));
    }
}
