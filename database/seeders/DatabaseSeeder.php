<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            SiteSettingsSeeder::class,
            HomePageSeeder::class,
            WhyChooseUsSeeder::class,
            ServicesSeeder::class,
            IndustriesSeeder::class,
            QualityComplianceSeeder::class,
            SpecimenLibrarySeeder::class,
            ContactPageSeeder::class,
            FAQSeeder::class,
            HomepageExtrasSeeder::class,
            ContactInquirySeeder::class,
            MenuSeeder::class,
        ]);
    }
}
