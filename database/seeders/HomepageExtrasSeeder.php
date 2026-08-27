<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class HomepageExtrasSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Dr. Sarah Chen',
                'role' => 'R&D Director, Diagnostic Reagents',
                'quote' => 'We came to LyoVial after a botched cycle at a general CDMO cost us a full batch of calibrator. They rebuilt the formulation, locked a proper cycle, and handed over documentation the next manufacturer accepted without a single question. That\'s the standard we\'ve held every partner to since.',
                'avatar' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=200&auto=format&fit=crop&q=80',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'name' => 'Marc Lévesque',
                'role' => 'VP Operations, Biotech Startup',
                'quote' => 'The other quotes we got treated our pilot batches as a scheduling headache. LyoVial treated the freeze-drying cycle as the actual problem. Straightforward answers, realistic timelines, and a cake we could reconstitute the same way every time — which is the entire point.',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&auto=format&fit=crop&q=80',
                'rating' => 5,
                'sort_order' => 2,
            ],
        ];

        foreach ($testimonials as $row) {
            Testimonial::query()->updateOrCreate(
                ['name' => $row['name']],
                array_merge($row, ['status' => true, 'show_on_home' => true])
            );
        }

        $articles = [
            [
                'title' => 'Choosing the right cryoprotectant for diagnostic reagent lyophilization',
                'slug' => 'choosing-the-right-cryoprotectant',
                'excerpt' => 'Working notes on cryoprotectant selection for diagnostic reagent lyo.',
                'featured_image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=800&auto=format&fit=crop&q=80',
                'author_name' => 'Dr. Amelia Reed',
                'author_role' => 'Formulation Scientist',
                'author_avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&auto=format&fit=crop&q=80',
                'published_at' => '2025-11-02 10:00:00',
                'sort_order' => 1,
            ],
            [
                'title' => 'Why your bench-scale cycle won\'t survive scale-up (and how to fix it)',
                'slug' => 'bench-scale-cycle-scale-up',
                'excerpt' => 'Common pitfalls when moving a benchtop cycle to pilot batch size.',
                'featured_image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&auto=format&fit=crop&q=80',
                'author_name' => 'James Okafor',
                'author_role' => 'Lyo Process Engineer',
                'author_avatar' => 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?w=200&auto=format&fit=crop&q=80',
                'published_at' => '2025-06-12 10:00:00',
                'sort_order' => 2,
            ],
            [
                'title' => 'Documentation that transfers: what a good lyo batch record looks like',
                'slug' => 'documentation-that-transfers',
                'excerpt' => 'What next-stage manufacturers actually need from your batch records.',
                'featured_image' => 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=800&auto=format&fit=crop&q=80',
                'author_name' => 'Dr. Priya Sharma',
                'author_role' => 'Lyo Cycle Lead',
                'author_avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=200&auto=format&fit=crop&q=80',
                'published_at' => '2025-08-03 10:00:00',
                'sort_order' => 3,
            ],
        ];

        foreach ($articles as $row) {
            Article::query()->updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, [
                    'status' => true,
                    'show_on_home' => true,
                    'content' => self::articleBody($row['slug']),
                ])
            );
        }
    }

    protected static function articleBody(string $slug): string
    {
        return match ($slug) {
            'choosing-the-right-cryoprotectant' => <<<'HTML'
<p>Cryoprotectant choice is one of the first formulation decisions that shows up later as cake collapse, reconstitution haze, or a cycle that cannot be scaled. These notes cover how we think about that choice for diagnostic reagents — not a universal recipe, a working frame.</p>
<h2>What the cryoprotectant is actually doing</h2>
<p>During freezing, ice formation concentrates the remaining solute. Without a protectant, proteins and other assay components can denature at that interface or adsorb to ice. The protectant is there to keep the remaining matrix glassy enough, and the active stable enough, until primary drying starts.</p>
<h2>Common starting points</h2>
<p>Sucrose, trehalose, and mannitol show up most often in diagnostic work. Sucrose is a reliable glass-former. Trehalose is often chosen where residual moisture or storage temperature is a concern. Mannitol crystallizes, which can help cake structure but can also exclude protein from the amorphous phase if the ratio is wrong.</p>
<h3>When crystallization helps</h3>
<p>A partially crystalline bulking agent can give a more robust cake and a shorter cycle. It only helps if the active remains in a stable amorphous fraction and the crystallized phase does not fracture vials or create reconstitution fines.</p>
<h2>How we screen without over-running the lab</h2>
<p>We typically compare two or three protectant systems at a small vial count, looking at cake appearance, reconstitution time, and a functional readout that actually matters for the assay. The winner is the system that survives the next scale step, not the prettiest cake on the bench.</p>
<h2>What to lock before cycle development</h2>
<p>Once a protectant is chosen, lock the solids content and fill volume before you spend time optimizing shelf temperature. Changing either later forces you to re-map drying, which is why we treat formulation freeze as a real gate, not a suggestion.</p>
HTML,
            'bench-scale-cycle-scale-up' => <<<'HTML'
<p>A cycle that works in five vials often fails at fifty or five hundred for reasons that have nothing to do with the science being "wrong." Load, radiation, and edge vials change the heat and mass transfer picture. Scale-up is the work of catching that gap on purpose.</p>
<h2>Why bench data misleads</h2>
<p>At very small loads the shelves and chamber walls dominate. Edge vials dry faster. A cycle tuned on that load can look conservative until the middle of a full shelf is still frozen while the edge is already overdried.</p>
<h2>What we change at pilot scale</h2>
<p>We keep the same vial, stopper, and fill where we can. What we re-examine is shelf temperature during primary drying, soak times, and how we confirm endpoint — not by copying a stop time from a five-vial run.</p>
<h3>Endpoint is not a clock</h3>
<p>Time-based stops transfer poorly. Pressure-rise, comparative pressure, or product thermocouple trends (used carefully) give you something a receiving team can defend when the load pattern is different.</p>
<h2>How to fix a cycle that will not scale</h2>
<p>Go back to the formulation constraints first: collapse temperature, fill depth, and cake resistance. Then rebuild primary drying with a margin that still finishes in a practical window. Document every change so the next manufacturer is not reverse-engineering your notebook.</p>
<h2>The transfer test</h2>
<p>A scaled cycle is ready when another operator can run it from the batch record and get the same cake, moisture range, and reconstitution behaviour. If that sentence is not true yet, the cycle is still in development — even if the bench vials looked perfect.</p>
HTML,
            'documentation-that-transfers' => <<<'HTML'
<p>Next-stage manufacturers do not need a novel. They need a record they can pick up without a call to reconstruct what you did. Good lyo documentation is formatted for that hand-off.</p>
<h2>What actually gets read</h2>
<p>Process summaries for freezing, primary drying, and secondary drying. Critical parameter ranges with a short rationale. Observed cake appearance, residual moisture, and reconstitution notes. Equipment differences you already know will matter.</p>
<h2>Batch records built for someone else</h2>
<p>Write as if the reader has your vials but not your lab habits. Include vial format, fill volume, stopper and seal, load pattern, and how endpoint was judged. Skip internal shorthand.</p>
<h3>Photos and exceptions</h3>
<figure class="image">
<img src="/images/site/ind-2.jpg" alt="Representative lyophilized vial cakes from a documented pilot run">
<figcaption>A representative cake photo and a note on atypical vials save more time than a paragraph of adjectives.</figcaption>
</figure>
<p>Record exceptions in the same place every run so they are not lost in email.</p>
<h2>What not to bury</h2>
<p>Hold points, known sensitivities, and anything that broke once and was fixed. Those are the details that prevent a receiving team from repeating a six-week mistake.</p>
<h2>A clean package</h2>
<p>When the record can move with the product — to your own suite or a larger partner — the development work holds its value. That is the standard we write to at LyoVial.</p>
HTML,
            default => '<p></p>',
        };
    }
}
