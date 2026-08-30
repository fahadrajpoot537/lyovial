<?php

namespace Tests\Unit;

use App\Support\AdminSlug;
use PHPUnit\Framework\TestCase;

class AdminSlugTest extends TestCase
{
    public function test_it_slugifies_titles_and_spaces(): void
    {
        $this->assertSame('our-story', AdminSlug::normalize('Our Story'));
        $this->assertSame('test-blog', AdminSlug::normalize('  Test Blog  '));
        $this->assertNull(AdminSlug::normalize(''));
        $this->assertNull(AdminSlug::normalize('!!!'));
    }
}
