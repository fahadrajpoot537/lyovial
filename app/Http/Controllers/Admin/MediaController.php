<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMediaRequest;
use App\Http\Requests\Admin\UpdateMediaRequest;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(protected MediaService $mediaService) {}

    public function index(Request $request): View
    {
        $media = Media::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('original_name', 'like', "%{$search}%")
                        ->orWhere('alt_text', 'like', "%{$search}%")
                        ->orWhere('folder', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('folder'), fn ($query) => $query->where('folder', $request->string('folder')))
            ->latest()
            ->paginate(24)
            ->withQueryString();

        return view('admin.media.index', compact('media'));
    }

    public function store(StoreMediaRequest $request): JsonResponse|RedirectResponse
    {
        $media = $this->mediaService->upload(
            $request->file('file'),
            $request->input('folder', 'uploads'),
            $request->only(['alt_text', 'title', 'caption', 'seo_name'])
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'media' => $media,
                'url' => $media->url,
            ]);
        }

        return back()->with('success', 'Media uploaded successfully.');
    }

    public function update(UpdateMediaRequest $request, Media $media): RedirectResponse
    {
        $media->update($request->validated());

        return back()->with('success', 'Media updated successfully.');
    }

    public function replace(Request $request, Media $media): RedirectResponse|JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'],
        ]);

        $replaced = $this->mediaService->replace($media, $request->file('file'));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'media' => $replaced,
                'url' => $replaced->url,
            ]);
        }

        return back()->with('success', 'Media replaced successfully.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        $this->mediaService->delete($media, force: true);

        return back()->with('success', 'Media deleted successfully.');
    }

    public function uploadEditor(Request $request): JsonResponse
    {
        $request->validate([
            'upload' => ['required', 'file', 'image', 'max:5120'],
        ]);

        /** @var UploadedFile $file */
        $file = $request->file('upload');
        $media = $this->mediaService->upload($file, 'editor');

        return response()->json([
            'url' => storage_url($media->path) ?: $media->url,
            'uploaded' => true,
        ]);
    }
}
