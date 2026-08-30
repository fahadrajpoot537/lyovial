<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Admin\Concerns\HandlesSeoUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactPageRequest;
use App\Models\ContactPage;
use App\Support\SeoHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactPageController extends Controller
{
    use HandlesImageUpload, HandlesSeoUploads;

    public function edit(): View
    {
        $contact = ContactPage::current()->load('seo');

        return view('admin.contact.edit', compact('contact'));
    }

    public function update(ContactPageRequest $request): RedirectResponse
    {
        $contactPage = ContactPage::current();
        $data = collect($request->validated())->except(SeoHelper::fields())->all();
        $data['banner_image'] = $this->resolveImageField($request, 'banner_image', 'contact', $contactPage->banner_image);

        $contactPage->update($data);
        $this->syncSeoFromRequest($request, $request->validated(), $contactPage);

        return back()->with('success', 'Contact page updated successfully.');
    }
}
