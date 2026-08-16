<?php

namespace Tests\Feature;

use Tests\TestCase;

class CanonicalHomepageRedirectTest extends TestCase
{
    public function test_index_php_redirects_to_canonical_homepage(): void
    {
        $response = $this->get('https://lyovial.com/index.php');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com');
    }

    public function test_public_path_redirects_to_canonical_homepage(): void
    {
        $response = $this->get('https://lyovial.com/public/');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com');
    }

    public function test_homepage_query_string_redirects_to_canonical_homepage(): void
    {
        $response = $this->get('https://lyovial.com/?query=1');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com');
    }

    public function test_www_host_redirects_to_canonical_homepage(): void
    {
        $response = $this->get('https://www.lyovial.com/');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com');
    }

    public function test_www_with_homepage_query_is_single_hop_to_canonical(): void
    {
        $response = $this->get('https://www.lyovial.com/?query=1');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com');
    }

    public function test_www_inner_path_preserves_path_and_query(): void
    {
        $response = $this->get('https://www.lyovial.com/contact?ref=nav');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com/contact?ref=nav');
    }

    public function test_http_redirects_to_https_preserving_path_and_query(): void
    {
        $response = $this->get('http://lyovial.com/contact?id=5');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com/contact?id=5');
    }

    public function test_http_www_redirects_in_single_hop_to_https_apex(): void
    {
        $response = $this->get('http://www.lyovial.com/about');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com/about');
    }

    public function test_non_home_query_strings_are_not_stripped_on_apex_https(): void
    {
        $response = $this->get('https://lyovial.com/contact?ref=nav');

        $response->assertStatus(200);
    }

    public function test_admin_http_is_upgraded_to_https_without_losing_path(): void
    {
        $response = $this->get('http://lyovial.com/admin/login');

        $response->assertStatus(301);
        $response->assertRedirect('https://lyovial.com/admin/login');
    }

    public function test_local_host_is_not_redirected(): void
    {
        $response = $this->get('http://127.0.0.1:8000/?query=1');

        $this->assertNotEquals(301, $response->status());
    }
}
