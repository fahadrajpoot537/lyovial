<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\ContactPage;
use App\Services\Recaptcha;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        $contact = ContactPage::current()->load('seo');

        return view('front.contact', compact('contact'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        // Theme field aliases
        if (! $request->filled('phone') && $request->filled('form_phone')) {
            $request->merge(['phone' => $request->input('form_phone')]);
        }
        if (! $request->filled('company') && $request->filled('subject')) {
            $request->merge(['company' => $request->input('subject')]);
        }

        Recaptcha::validate($request->input('g-recaptcha-response'), $request->ip());

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactInquiry::create([
            ...$data,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'status' => ContactInquiry::STATUS_NEW,
        ]);

        $message = 'Thank you. Your message has been sent to the LyoVial team.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
