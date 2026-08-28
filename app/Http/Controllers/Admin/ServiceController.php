<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use App\Models\ServiceGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $services = Service::query()->orderBy('sort_order')->latest('id')->paginate(20);

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated, ['galleries']);
        $data['banner_image'] = $this->uploadImage($request, 'banner_image', 'services');
        $data['featured_image'] = $this->uploadImage($request, 'featured_image', 'services');
        $data['extra'] = $this->normalizeServiceExtra($request->input('extra', []));
        $validated['slug'] = $data['slug'];

        $service = Service::create(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $validated, $service);
        $this->syncGalleries($service, $request);

        return redirect()
            ->route('admin.services.edit', $service)
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service): RedirectResponse
    {
        return redirect()->route('admin.services.edit', $service);
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', [
            'service' => $service->load(['galleries', 'seo']),
        ]);
    }

    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        $validated = $request->validated();
        $data = $this->payloadWithoutSeo($validated, ['galleries']);
        $data['banner_image'] = $this->resolveImageField($request, 'banner_image', 'services', $service->banner_image);
        $data['featured_image'] = $this->resolveImageField($request, 'featured_image', 'services', $service->featured_image);
        $data['extra'] = $this->normalizeServiceExtra($request->input('extra', []));
        $validated['slug'] = $data['slug'];

        $service->update(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $validated, $service);
        $this->syncGalleries($service, $request);

        return back()->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    protected function syncGalleries(Service $service, Request $request): void
    {
        $galleries = $request->input('galleries', []);
        $keptIds = [];

        foreach ($galleries as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $image = null;
            if ($request->hasFile("galleries.{$index}.image")) {
                $image = $this->uploadImage($request, "galleries.{$index}.image", 'services/gallery');
            } elseif (! empty($item['image']) && is_string($item['image'])) {
                $image = $item['image'];
            }

            if (empty($item['id'])) {
                if (! $image) {
                    continue;
                }

                $gallery = $service->galleries()->create([
                    'image' => $image,
                    'alt_text' => $item['alt_text'] ?? null,
                    'title' => $item['title'] ?? null,
                    'sort_order' => $item['sort_order'] ?? $index,
                ]);
                $keptIds[] = $gallery->id;

                continue;
            }

            /** @var ServiceGallery|null $gallery */
            $gallery = $service->galleries()->find($item['id']);
            if (! $gallery) {
                continue;
            }

            $gallery->update([
                'image' => $image ?? $gallery->image,
                'alt_text' => $item['alt_text'] ?? $gallery->alt_text,
                'title' => $item['title'] ?? $gallery->title,
                'sort_order' => $item['sort_order'] ?? $index,
            ]);
            $keptIds[] = $gallery->id;
        }

        $service->galleries()->whereNotIn('id', $keptIds)->delete();
    }

    protected function normalizeServiceExtra(mixed $extra): array
    {
        if (! is_array($extra)) {
            return [];
        }

        $includes = collect($extra['includes'] ?? [])
            ->filter(fn ($row) => is_array($row) && filled($row['title'] ?? null))
            ->values()
            ->all();

        $steps = collect($extra['steps'] ?? [])
            ->filter(fn ($row) => is_array($row) && filled($row['title'] ?? null))
            ->values()
            ->all();

        $why = collect($extra['why_bullets'] ?? [])
            ->filter(fn ($row) => filled($row))
            ->values()
            ->all();

        return [
            'eyebrow' => $extra['eyebrow'] ?? '',
            'intro_heading' => $extra['intro_heading'] ?? '',
            'includes_heading' => $extra['includes_heading'] ?? '',
            'includes' => $includes,
            'why_heading' => $extra['why_heading'] ?? '',
            'why_bullets' => $why,
            'steps_heading' => $extra['steps_heading'] ?? '',
            'steps_intro' => $extra['steps_intro'] ?? '',
            'steps' => $steps,
            'related_heading' => $extra['related_heading'] ?? '',
            'sidebar_cta_title' => $extra['sidebar_cta_title'] ?? '',
            'sidebar_cta_body' => $extra['sidebar_cta_body'] ?? '',
            'sidebar_cta_button' => $extra['sidebar_cta_button'] ?? '',
            'bottom_cta_heading' => $extra['bottom_cta_heading'] ?? '',
            'bottom_cta_body' => $extra['bottom_cta_body'] ?? '',
            'bottom_cta_button' => $extra['bottom_cta_button'] ?? '',
        ];
    }
}
