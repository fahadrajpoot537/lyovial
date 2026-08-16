<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::query()->where('location', 'header')->forceDelete();
        Cache::forget('menus.header');
        Cache::forget('menus.footer');

        $home = Menu::query()->create([
            'parent_id' => null,
            'location' => 'header',
            'title' => 'Home',
            'url' => '/',
            'type' => 'custom',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $capabilities = Menu::query()->create([
            'parent_id' => null,
            'location' => 'header',
            'title' => 'Capabilities',
            'url' => '/capabilities',
            'type' => 'dropdown',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $services = Service::query()->orderBy('sort_order')->get();
        foreach ($services as $index => $service) {
            Menu::query()->create([
                'parent_id' => $capabilities->id,
                'location' => 'header',
                'title' => $service->title,
                'url' => '/capabilities/'.$service->slug,
                'type' => 'service',
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $index + 1,
            ]);
        }

        Menu::query()->create([
            'parent_id' => null,
            'location' => 'header',
            'title' => 'Industries We Serve',
            'url' => '/industries',
            'type' => 'custom',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        Menu::query()->create([
            'parent_id' => null,
            'location' => 'header',
            'title' => 'Quality & Compliance',
            'url' => '/quality-compliance',
            'type' => 'custom',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        Menu::query()->create([
            'parent_id' => null,
            'location' => 'header',
            'title' => 'Specimen Library Preservation',
            'url' => '/specimen-library-preservation',
            'type' => 'custom',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 5,
        ]);

        Menu::query()->create([
            'parent_id' => null,
            'location' => 'header',
            'title' => 'Contact',
            'url' => '/contact',
            'type' => 'custom',
            'target' => '_self',
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // Footer quick links
        $footerItems = [
            ['title' => 'Capabilities', 'url' => '/capabilities', 'sort_order' => 1],
            ['title' => 'Industries', 'url' => '/industries', 'sort_order' => 2],
            ['title' => 'Quality & Compliance', 'url' => '/quality-compliance', 'sort_order' => 3],
            ['title' => 'Contact', 'url' => '/contact', 'sort_order' => 4],
        ];

        Menu::query()->where('location', 'footer')->forceDelete();

        foreach ($footerItems as $item) {
            Menu::query()->create([
                'parent_id' => null,
                'location' => 'footer',
                'title' => $item['title'],
                'url' => $item['url'],
                'type' => 'custom',
                'target' => '_self',
                'is_active' => true,
                'sort_order' => $item['sort_order'],
            ]);
        }

        unset($home);
    }
}
