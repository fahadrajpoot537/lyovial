<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorageFileServingTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploaded_storage_files_are_served_without_a_symlink(): void
    {
        $relative = 'cms-test/hello.txt';
        $full = storage_path('app/public/'.$relative);
        if (! is_dir(dirname($full))) {
            mkdir(dirname($full), 0755, true);
        }
        file_put_contents($full, 'ok');

        try {
            $this->get('/storage/'.$relative)->assertOk();
        } finally {
            @unlink($full);
            @rmdir(dirname($full));
        }
    }

    public function test_storage_path_traversal_is_rejected(): void
    {
        $this->get('/storage/../.env')->assertNotFound();
    }
}
