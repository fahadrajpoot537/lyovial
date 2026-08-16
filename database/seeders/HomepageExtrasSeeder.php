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
                    'content' => '<p>'.e($row['excerpt']).'</p>',
                ])
            );
        }
    }
}
