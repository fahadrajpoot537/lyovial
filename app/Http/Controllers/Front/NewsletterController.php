<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Services\Recaptcha;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        Recaptcha::validate($request->input('g-recaptcha-response'), $request->ip());

        $email = $request->input('email') ?: $request->input('EMAIL');

        $data = validator(
            ['email' => $email],
            ['email' => ['required', 'email', 'max:255']]
        )->validate();

        NewsletterSubscriber::query()->updateOrCreate(
            ['email' => strtolower($data['email'])],
            [
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
                'is_active' => true,
                'subscribed_at' => now(),
            ]
        );

        $message = 'Thanks for subscribing to the LyoVial newsletter.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
