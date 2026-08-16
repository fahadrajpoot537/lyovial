<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhyChooseItemRequest;
use App\Models\WhyChooseItem;
use App\Support\SeoHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WhyChooseItemController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $items = WhyChooseItem::query()->orderBy('sort_order')->paginate(20);

        return view('admin.why-choose.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.why-choose.create');
    }

    public function store(WhyChooseItemRequest $request): RedirectResponse
    {
        $data = collect($request->validated())->except(SeoHelper::fields())->all();
        $data['image'] = $this->uploadImage($request, 'image', 'why-choose');
        $data['status'] = $request->boolean('status');

        $item = WhyChooseItem::create(array_filter($data, fn ($value) => $value !== null));
        $this->syncSeoFromRequest($request, $request->validated(), $item);

        return redirect()
            ->route('admin.why-choose.index')
            ->with('success', 'Why choose item created successfully.');
    }

    public function edit(WhyChooseItem $whyChooseItem): View
    {
        return view('admin.why-choose.edit', [
            'item' => $whyChooseItem->load('seo'),
        ]);
    }

    public function update(WhyChooseItemRequest $request, WhyChooseItem $whyChooseItem): RedirectResponse
    {
        $data = collect($request->validated())->except(SeoHelper::fields())->all();
        $data['image'] = $this->resolveImageField($request, 'image', 'why-choose', $whyChooseItem->image);
        $data['status'] = $request->boolean('status');

        $whyChooseItem->update($data);
        $this->syncSeoFromRequest($request, $request->validated(), $whyChooseItem);

        return back()->with('success', 'Why choose item updated successfully.');
    }

    public function destroy(WhyChooseItem $whyChooseItem): RedirectResponse
    {
        $whyChooseItem->delete();

        return redirect()
            ->route('admin.why-choose.index')
            ->with('success', 'Why choose item deleted successfully.');
    }
}
