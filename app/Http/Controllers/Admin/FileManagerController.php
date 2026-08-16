<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManagedFile;
use App\Services\FileManagerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FileManagerController extends Controller
{
    public function __construct(protected FileManagerService $fileManagerService) {}

    public function index(Request $request): View
    {
        $files = ManagedFile::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('original_name', 'like', "%{$search}%")
                        ->orWhere('folder', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('folder'), fn ($query) => $query->where('folder', $request->string('folder')))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.files.index', compact('files'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'max:20480'],
            'folder' => ['nullable', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $this->fileManagerService->upload(
            $request->file('file'),
            $validated['folder'] ?? 'documents',
            $request->only(['title', 'description'])
        );

        return back()->with('success', 'File uploaded successfully.');
    }

    public function destroy(ManagedFile $file): RedirectResponse
    {
        $this->fileManagerService->delete($file, force: true);

        return back()->with('success', 'File deleted successfully.');
    }
}
