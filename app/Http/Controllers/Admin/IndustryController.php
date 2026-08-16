<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IndustryRequest;
use App\Models\Industry;
use App\Support\SeoHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IndustryController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $industries = Industry::query()->orderBy('sort_order')->latest('id')->paginate(20);

        return view('admin.industries.index', compact('industries'));
    }

    public function create(): View
    {
        return view('admin.industries.create');
    }

    public function store(IndustryRequest $request): RedirectResponse
    {
        $data = collect($request->validated())->except(SeoHelper::fields())->all();
        $data['banner_image'] = $this->uploadImage($request, 'banner_image', 'industries');
        $data['image'] = $this->uploadImage($request, 'image', 'industries');

        $industry = Industry::create(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $request->validated(), $industry);

        return redirect()
            ->route('admin.industries.edit', $industry)
            ->with('success', 'Industry created successfully.');
    }

    public function show(Industry $industry): RedirectResponse
    {
        return redirect()->route('admin.industries.edit', $industry);
    }

    public function edit(Industry $industry): View
    {
        return view('admin.industries.edit', [
            'industry' => $industry->load('seo'),
        ]);
    }

    public function update(IndustryRequest $request, Industry $industry): RedirectResponse
    {
        $data = collect($request->validated())->except(SeoHelper::fields())->all();
        $data['banner_image'] = $this->resolveImageField($request, 'banner_image', 'industries', $industry->banner_image);
        $data['image'] = $this->resolveImageField($request, 'image', 'industries', $industry->image);

        $industry->update(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $request->validated(), $industry);

        return back()->with('success', 'Industry updated successfully.');
    }

    public function destroy(Industry $industry): RedirectResponse
    {
        $industry->delete();

        return redirect()
            ->route('admin.industries.index')
            ->with('success', 'Industry deleted successfully.');
    }
}
