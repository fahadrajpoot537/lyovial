<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ContactInquiryMail;
use App\Models\ContactInquiry;
use App\Models\ContactPage;
use App\Services\Recaptcha;
use App\Support\PhpMailSender;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

        $inquiry = ContactInquiry::create([
            ...$data,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 255),
            'status' => ContactInquiry::STATUS_NEW,
        ]);

        $recipient = ContactInquiryMail::recipientAddress();

        if ($recipient === null) {
            Log::error('Contact inquiry email failed.', [
                'inquiry_id' => $inquiry->id,
                'error' => 'Inquiry notification recipient is missing or invalid.',
            ]);
        } else {
            try {
                $this->sendInquiryNotification($inquiry, $recipient);
            } catch (\Throwable $e) {
                Log::error('Contact inquiry email failed.', [
                    'inquiry_id' => $inquiry->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $message = 'Thank you. Your message has been sent to the LyoVial team.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }

    private function sendInquiryNotification(ContactInquiry $inquiry, string $recipient): void
    {
        $name = ContactInquiryMail::recipientName();

        try {
            PhpMailSender::send($inquiry, $recipient, $name);
            Log::info('Contact inquiry email sent.', [
                'inquiry_id' => $inquiry->id,
                'mailer' => 'php_mail',
            ]);

            return;
        } catch (\Throwable $e) {
            Log::warning('Contact inquiry PHP mail() failed, trying SMTP.', [
                'inquiry_id' => $inquiry->id,
                'error' => $e->getMessage(),
            ]);
        }

        config(['mail.mailers.smtp.timeout' => 8]);
        Mail::purge();

        try {
            Mail::mailer(config('mail.default'))
                ->to($recipient, $name)
                ->send(new ContactInquiryMail($inquiry));

            Log::info('Contact inquiry email sent.', [
                'inquiry_id' => $inquiry->id,
                'mailer' => config('mail.default'),
            ]);

            return;
        } catch (\Throwable $e) {
            if (! $this->isSmtpUnreachable($e) || config('mail.default') === 'sendmail') {
                throw $e;
            }

            Log::warning('Contact inquiry SMTP unreachable, trying sendmail.', [
                'inquiry_id' => $inquiry->id,
            ]);
        }

        Mail::mailer('sendmail')
            ->to($recipient, $name)
            ->send(new ContactInquiryMail($inquiry));

        Log::info('Contact inquiry email sent.', [
            'inquiry_id' => $inquiry->id,
            'mailer' => 'sendmail',
        ]);
    }

    private function isSmtpUnreachable(\Throwable $e): bool
    {
        $message = strtolower($e->getMessage());

        return str_contains($message, 'timed out')
            || str_contains($message, 'connection could not be established')
            || str_contains($message, 'connection refused')
            || str_contains($message, 'network is unreachable');
    }
}
