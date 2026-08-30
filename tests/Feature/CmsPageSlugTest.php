<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CmsPageSlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_custom_page_is_reachable_by_admin_slug(): void
    {
        Page::query()->create([
            'title' => 'Custom',
            'slug' => 'our-custom-page',
            'type' => Page::TYPE_CUSTOM,
            'heading' => 'Hello CMS',
            'content' => '<p>Body</p>',
            'status' => true,
            'sort_order' => 0,
        ]);

        $this->get('/our-custom-page')
            ->assertOk()
            ->assertSee('Hello CMS');
    }

    public function test_changing_about_slug_redirects_from_the_old_url(): void
    {
        Page::query()->create([
            'title' => 'About Us',
            'slug' => 'our-story',
            'type' => Page::TYPE_ABOUT,
            'heading' => 'About heading',
            'status' => true,
            'sort_order' => 0,
            'extra' => [],
        ]);

        $this->get('/about')->assertRedirect('/our-story');
        $this->get('/our-story')->assertOk();
    }

    public function test_inactive_typed_page_returns_not_found(): void
    {
        Page::query()->create([
            'title' => 'About Us',
            'slug' => 'about',
            'type' => Page::TYPE_ABOUT,
            'heading' => 'Hidden',
            'status' => false,
            'sort_order' => 0,
            'extra' => [],
        ]);

        $this->get('/about')->assertNotFound();
    }
}
