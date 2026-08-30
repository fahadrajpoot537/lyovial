<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StorageFileController extends Controller
{
    public function __invoke(string $path): BinaryFileResponse
    {
        $relative = str_replace('\\', '/', $path);
        abort_if($relative === '' || str_contains($relative, '..'), 404);

        $candidates = [
            storage_path('app/public/'.$relative),
            public_path('uploads/'.$relative),
        ];

        foreach ($candidates as $full) {
            if (! is_file($full)) {
                continue;
            }

            $real = realpath($full);
            if ($real === false || ! $this->isAllowed($real)) {
                continue;
            }

            return response()->file($real);
        }

        abort(404);
    }

    protected function isAllowed(string $realPath): bool
    {
        $allowed = array_filter([
            realpath(storage_path('app/public')),
            realpath(public_path('uploads')),
        ]);

        foreach ($allowed as $root) {
            if (str_starts_with($realPath, $root.DIRECTORY_SEPARATOR) || $realPath === $root) {
                return true;
            }
        }

        return false;
    }
}
