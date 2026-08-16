<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use App\Support\SeoHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function index(): View
    {
        $faqs = Faq::query()
            ->when(request('section'), fn ($query, $section) => $query->forSection($section))
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        return view('admin.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        return view('admin.faqs.create');
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        $faq = Faq::create(collect($request->validated())->except(SeoHelper::fields())->all());
        $this->syncSeoFromRequest($request, $request->validated(), $faq);

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    public function show(Faq $faq): RedirectResponse
    {
        return redirect()->route('admin.faqs.edit', $faq);
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faqs.edit', [
            'faq' => $faq->load('seo'),
        ]);
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update(collect($request->validated())->except(SeoHelper::fields())->all());
        $this->syncSeoFromRequest($request, $request->validated(), $faq);

        return back()->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }
}
