<?php

namespace App\Mail;

use App\Models\ContactInquiry;
use App\Models\ContactPage;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactInquiry $inquiry) {}

    public function envelope(): Envelope
    {
        $to = self::recipientAddress();
        $toName = self::recipientName();

        return new Envelope(
            subject: 'New contact inquiry from '.$this->inquiry->name,
            to: $to ? [new Address($to, $toName)] : [],
            replyTo: [
                new Address($this->inquiry->email, $this->inquiry->name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-inquiry',
        );
    }

    /**
     * Resolve a trimmed, valid notification recipient.
     *
     * Prefers MAIL_TO_ADDRESS via config, then the admin general email setting,
     * then the contact page email. Returns null when none are valid.
     */
    public static function recipientAddress(): ?string
    {
        foreach ([
            config('mail.contact.address'),
            fn () => Setting::get('email', null, 'general'),
            fn () => ContactPage::query()->value('email'),
        ] as $candidate) {
            $email = trim((string) (is_callable($candidate) ? $candidate() : $candidate));

            if (self::isValidEmail($email)) {
                return $email;
            }
        }

        return null;
    }

    public static function recipientName(): string
    {
        $name = trim((string) config('mail.contact.name'));

        return $name !== '' ? $name : (string) config('app.name');
    }

    public static function isValidEmail(string $email): bool
    {
        return $email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
