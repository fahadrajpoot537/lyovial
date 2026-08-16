<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    use HandlesImageUpload;

    public function index(): View
    {
        $items = Testimonial::query()->orderBy('sort_order')->paginate(20);

        return view('admin.testimonials.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.testimonials.create');
    }

    public function store(TestimonialRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['avatar'] = $this->uploadImage($request, 'avatar', 'testimonials');
        $data['status'] = $request->boolean('status');
        $data['show_on_home'] = $request->boolean('show_on_home');

        Testimonial::create(array_filter($data, fn ($value) => $value !== null));

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.edit', ['item' => $testimonial]);
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $request->validated();
        $data['avatar'] = $this->resolveImageField($request, 'avatar', 'testimonials', $testimonial->avatar);
        $data['status'] = $request->boolean('status');
        $data['show_on_home'] = $request->boolean('show_on_home');

        $testimonial->update($data);

        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}
