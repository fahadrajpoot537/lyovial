<?php

namespace Tests\Feature;

use App\Mail\ContactInquiryMail;
use App\Models\ContactInquiry;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactInquiryMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_sends_inquiry_mail_to_configured_recipient(): void
    {
        config([
            'mail.contact.address' => '  vlad@evik.ca  ',
            'mail.contact.name' => 'LyoVial',
            'services.recaptcha.enabled' => false,
        ]);

        Mail::fake();

        $response = $this->postJson('/contact', [
            'name' => 'Test Visitor',
            'email' => 'visitor@example.com',
            'message' => 'Please contact me about a lyophilization project.',
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Thank you. Your message has been sent to the LyoVial team.',
            ]);

        $this->assertDatabaseHas('contact_inquiries', [
            'email' => 'visitor@example.com',
            'name' => 'Test Visitor',
        ]);

        Mail::assertSent(ContactInquiryMail::class, function (ContactInquiryMail $mail) {
            return $mail->hasTo('vlad@evik.ca');
        });
    }

    public function test_invalid_recipient_skips_send_but_still_saves_inquiry(): void
    {
        config([
            'mail.contact.address' => 'not-an-email',
            'services.recaptcha.enabled' => false,
        ]);

        Mail::fake();

        $response = $this->postJson('/contact', [
            'name' => 'Test Visitor',
            'email' => 'visitor@example.com',
            'message' => 'Please contact me about a lyophilization project.',
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $this->assertNotNull(
            ContactInquiry::query()->where('email', 'visitor@example.com')->first()
        );

        Mail::assertNothingSent();
    }

    public function test_falls_back_to_admin_email_setting_when_env_recipient_is_empty(): void
    {
        config([
            'mail.contact.address' => '',
            'services.recaptcha.enabled' => false,
        ]);

        Setting::set('email', 'ops@example.com', 'general');

        Mail::fake();

        $this->postJson('/contact', [
            'name' => 'Test Visitor',
            'email' => 'visitor@example.com',
            'message' => 'Please contact me about a lyophilization project.',
        ])->assertOk();

        Mail::assertSent(ContactInquiryMail::class, function (ContactInquiryMail $mail) {
            return $mail->hasTo('ops@example.com');
        });
    }

    public function test_configured_recipient_is_a_valid_email(): void
    {
        config(['mail.contact.address' => 'vlad@evik.ca']);

        $recipient = ContactInquiryMail::recipientAddress();

        $this->assertNotNull($recipient);
        $this->assertTrue(ContactInquiryMail::isValidEmail($recipient));
    }
}
