<?php

namespace Database\Seeders;

use App\Models\ContactInquiry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ContactInquirySeeder extends Seeder
{
    public function run(): void
    {
        $inquiries = [
            [
                'name' => 'Emily Tremblay',
                'email' => 'emily.tremblay@northpeakdx.ca',
                'phone' => '(416) 555-0182',
                'company' => 'NorthPeak Diagnostics',
                'message' => 'We are converting a liquid immunoassay reagent to a lyophilized vial format and need help with formulation screening and cycle development. Looking for a discovery call next week.',
                'status' => ContactInquiry::STATUS_NEW,
                'days_ago' => 1,
            ],
            [
                'name' => 'James MacDonald',
                'email' => 'j.macdonald@canadacontrols.com',
                'phone' => '(905) 555-0144',
                'company' => 'Canada Controls Ltd.',
                'message' => 'Our QC team needs pilot lyophilized calibrator lots for an upcoming method verification. Can you support 2–5 mL vials and residual moisture targets around 1–2%?',
                'status' => ContactInquiry::STATUS_NEW,
                'days_ago' => 2,
            ],
            [
                'name' => 'Sophie Bélanger',
                'email' => 'sophie.belanger@laboraquebec.ca',
                'phone' => '(514) 555-0198',
                'company' => 'Labora Québec',
                'message' => 'We operate an analytical testing lab in Montreal and need a small freeze-dried reference material lot. Please share lead times and documentation options.',
                'status' => ContactInquiry::STATUS_READ,
                'days_ago' => 3,
                'notes' => 'Sent intro email and capability overview.',
            ],
            [
                'name' => 'Daniel Nguyen',
                'email' => 'dnguyen@pacificassay.com',
                'phone' => '(604) 555-0171',
                'company' => 'Pacific Assay Technologies',
                'message' => 'Interested in technology transfer support. We have a working lab cycle but need transferable documentation before engaging a commercial partner.',
                'status' => ContactInquiry::STATUS_READ,
                'days_ago' => 4,
                'notes' => 'Scheduled technical review for Thursday.',
            ],
            [
                'name' => 'Aisha Patel',
                'email' => 'aisha.patel@ottawareagents.ca',
                'phone' => '(613) 555-0119',
                'company' => 'Ottawa Reagent Works',
                'message' => 'Local Kanata visit preferred. We manufacture diagnostic reagents and want to discuss pilot-batch vial lyophilization for three SKUs.',
                'status' => ContactInquiry::STATUS_NEW,
                'days_ago' => 5,
            ],
            [
                'name' => 'Michael O’Connor',
                'email' => 'moconnor@atlanticmedia.ca',
                'phone' => '(902) 555-0160',
                'company' => 'Atlantic Media Supplies',
                'message' => 'Looking for lyophilization support for microbiology supplements. Current cakes are collapsing at elevated shelf temperatures during primary drying.',
                'status' => ContactInquiry::STATUS_READ,
                'days_ago' => 6,
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.sharma@utoronto.ca',
                'phone' => '(416) 555-0127',
                'company' => 'University of Toronto — Translational Lab',
                'message' => 'University R&D group seeking pilot lyophilized vials for a grant milestone. Budget is modest; need guidance on realistic scope.',
                'status' => ContactInquiry::STATUS_NEW,
                'days_ago' => 7,
            ],
            [
                'name' => 'Lucas Martin',
                'email' => 'lucas.martin@prairiedx.ca',
                'phone' => '(403) 555-0188',
                'company' => 'Prairie Dx Solutions',
                'message' => 'Calgary-based team developing a multiplex assay. We need formulation advice before committing to freeze-drying. Can you review our current buffer system?',
                'status' => ContactInquiry::STATUS_ARCHIVED,
                'days_ago' => 10,
                'notes' => 'Project deferred to next quarter.',
            ],
            [
                'name' => 'Hannah Clarke',
                'email' => 'hclarke@trueglowingredients.com',
                'phone' => '(647) 555-0133',
                'company' => 'TrueGlow Ingredients',
                'message' => 'Cosmetic active that is moisture sensitive. Interested in pilot lyophilization to improve shipping stability for North American customers.',
                'status' => ContactInquiry::STATUS_READ,
                'days_ago' => 8,
            ],
            [
                'name' => 'Robert Singh',
                'email' => 'rsingh@frontiercal.ca',
                'phone' => '(780) 555-0155',
                'company' => 'Frontier Calibration Inc.',
                'message' => 'We produce calibrators and controls. Need help shortening an existing 72-hour cycle without compromising cake appearance.',
                'status' => ContactInquiry::STATUS_NEW,
                'days_ago' => 2,
            ],
            [
                'name' => 'Camille Fortin',
                'email' => 'cfortin@biopathmtl.ca',
                'phone' => '(438) 555-0190',
                'company' => 'BioPath Montréal',
                'message' => 'Please send capabilities overview and typical timelines for cycle development + first pilot lot. French or English communication is fine.',
                'status' => ContactInquiry::STATUS_READ,
                'days_ago' => 9,
            ],
            [
                'name' => 'Ethan Brooks',
                'email' => 'ethan.brooks@shieldlabs.ca',
                'phone' => '(289) 555-0148',
                'company' => 'Shield Labs',
                'message' => 'Need specimen library preservation guidance for archived assay components. Looking for lyophilized vials with clear reconstitution instructions.',
                'status' => ContactInquiry::STATUS_NEW,
                'days_ago' => 3,
            ],
            [
                'name' => 'Natalie Wu',
                'email' => 'natalie.wu@cascadeassays.com',
                'phone' => '(778) 555-0122',
                'company' => 'Cascade Assays',
                'message' => 'Vancouver team evaluating Canadian freeze-drying partners. Can LyoVial support both development and recurring pilot batches?',
                'status' => ContactInquiry::STATUS_READ,
                'days_ago' => 11,
                'notes' => 'Qualified lead — send proposal outline.',
            ],
            [
                'name' => 'Omar Hassan',
                'email' => 'omar.hassan@medisignal.ca',
                'phone' => '(519) 555-0177',
                'company' => 'MediSignal Technologies',
                'message' => 'We have DSC data already. Seeking a partner to turn thermal characterization into a practical primary drying design for 10R vials.',
                'status' => ContactInquiry::STATUS_NEW,
                'days_ago' => 0,
            ],
            [
                'name' => 'Grace Lefebvre',
                'email' => 'grace.lefebvre@nrc-cnrc.gc.ca',
                'phone' => '(613) 555-0104',
                'company' => 'Institutional Research Group — Ottawa',
                'message' => 'Institutional R&D collaboration inquiry regarding lyophilized research reagents for partner distribution. Please advise on intake process.',
                'status' => ContactInquiry::STATUS_READ,
                'days_ago' => 12,
            ],
        ];

        foreach ($inquiries as $item) {
            $createdAt = Carbon::now()->subDays($item['days_ago'])->setTime(rand(8, 17), rand(0, 59));

            ContactInquiry::query()->updateOrCreate(
                ['email' => $item['email'], 'message' => $item['message']],
                [
                    'name' => $item['name'],
                    'phone' => $item['phone'],
                    'company' => $item['company'],
                    'ip_address' => '99.'.rand(10, 200).'.'.rand(10, 200).'.'.rand(10, 200),
                    'user_agent' => 'Mozilla/5.0 (compatible; LyoVialSeeder/1.0)',
                    'status' => $item['status'],
                    'notes' => $item['notes'] ?? null,
                    'read_at' => $item['status'] === ContactInquiry::STATUS_NEW ? null : $createdAt->copy()->addHours(2),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]
            );
        }
    }
}
