<?php

namespace App\Support;

use App\Models\ContactInquiry;
use RuntimeException;

class PhpMailSender
{
    /**
     * Send via PHP mail() (shared hosting, no outbound SMTP required).
     */
    public static function send(ContactInquiry $inquiry, string $to, string $toName): void
    {
        $to = self::safeEmail($to);
        $from = self::safeEmail((string) config('mail.from.address'));
        $fromName = self::safeHeader((string) config('mail.from.name', 'LyoVial'));
        $replyTo = self::safeEmail((string) $inquiry->email);

        if ($to === '' || $from === '') {
            throw new RuntimeException('PHP mail() is missing a valid From or To address.');
        }

        $subject = 'New contact inquiry from '.self::safeHeader((string) $inquiry->name);
        $html = view('emails.contact-inquiry', compact('inquiry'))->render();

        $headers = implode("\r\n", [
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
            'From: '.sprintf('%s <%s>', $fromName, $from),
            'Reply-To: '.$replyTo,
            'X-Mailer: LyoVial',
        ]);

        $encodedSubject = '=?UTF-8?B?'.base64_encode($subject).'?=';

        $sent = @mail($to, $encodedSubject, $html, $headers, '-f'.$from);

        if ($sent !== true) {
            throw new RuntimeException('PHP mail() returned false.');
        }
    }

    private static function safeEmail(string $value): string
    {
        $value = trim(str_replace(["\r", "\n", "\0"], '', $value));

        return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : '';
    }

    private static function safeHeader(string $value): string
    {
        return trim(str_replace(["\r", "\n", "\0"], '', $value));
    }
}
