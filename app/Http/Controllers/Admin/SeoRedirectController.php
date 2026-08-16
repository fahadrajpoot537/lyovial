<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeoRedirectRequest;
use App\Models\SeoRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SeoRedirectController extends Controller
{
    public function index(): View
    {
        $redirects = SeoRedirect::query()->latest('id')->paginate(30);

        return view('admin.seo-redirects.index', compact('redirects'));
    }

    public function store(SeoRedirectRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['from_path'] = SeoRedirect::normalizePath($data['from_path']);

        SeoRedirect::create($data);

        return back()->with('success', 'Redirect created successfully.');
    }

    public function update(SeoRedirectRequest $request, SeoRedirect $seoRedirect): RedirectResponse
    {
        $data = $request->validated();
        $data['from_path'] = SeoRedirect::normalizePath($data['from_path']);

        $seoRedirect->update($data);

        return back()->with('success', 'Redirect updated successfully.');
    }

    public function destroy(SeoRedirect $seoRedirect): RedirectResponse
    {
        $seoRedirect->delete();

        return back()->with('success', 'Redirect deleted successfully.');
    }
}
