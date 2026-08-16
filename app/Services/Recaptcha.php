<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Recaptcha
{
    public static function siteKey(): string
    {
        return self::enabled() ? (string) config('services.recaptcha.site_key') : '';
    }

    public static function secretKey(): string
    {
        return (string) config('services.recaptcha.secret_key');
    }

    public static function enabled(): bool
    {
        if (! filter_var(config('services.recaptcha.enabled', false), FILTER_VALIDATE_BOOLEAN)) {
            return false;
        }

        return filled(config('services.recaptcha.site_key'))
            && filled(config('services.recaptcha.secret_key'));
    }

    /**
     * @throws ValidationException
     */
    public static function validate(?string $token, ?string $ip = null): void
    {
        if (! self::enabled()) {
            return;
        }

        if (! filled($token)) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Please complete the captcha.',
            ]);
        }

        try {
            $response = Http::asForm()
                ->timeout(8)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => self::secretKey(),
                    'response' => $token,
                    'remoteip' => $ip,
                ]);
        } catch (\Throwable $e) {
            Log::warning('reCAPTCHA request failed', ['message' => $e->getMessage()]);

            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Captcha verification failed. Please try again.',
            ]);
        }

        if (! $response->ok() || $response->json('success') !== true) {
            Log::warning('reCAPTCHA verification rejected', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Captcha verification failed. Please try again.',
            ]);
        }
    }
}
