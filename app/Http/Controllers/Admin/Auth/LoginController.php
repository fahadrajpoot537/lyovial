<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\User;
use App\Services\Recaptcha;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('admin.auth.login', [
            'recaptchaSiteKey' => Recaptcha::siteKey(),
        ]);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $this->ensureIsNotRateLimited($request);

        Recaptcha::validate($request->input('g-recaptcha-response'), $request->ip());

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            if ($this->bootstrapDefaultAdminIfMissing() && Auth::attempt($credentials, $remember)) {
                // First-run database had no users; default admin was created.
            } else {
                RateLimiter::hit($this->throttleKey($request));

                throw ValidationException::withMessages([
                    'email' => __('These credentials do not match our records.'),
                ]);
            }
        }

        $request->session()->regenerate();
        RateLimiter::clear($this->throttleKey($request));

        if (! Auth::user()?->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => __('Your account has been deactivated.'),
            ]);
        }

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    protected function ensureIsNotRateLimited(LoginRequest $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        throw ValidationException::withMessages([
            'email' => __('Too many login attempts. Please try again in :seconds seconds.', [
                'seconds' => RateLimiter::availableIn($this->throttleKey($request)),
            ]),
        ]);
    }

    protected function throttleKey(LoginRequest $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }

    protected function bootstrapDefaultAdminIfMissing(): bool
    {
        if (User::query()->withTrashed()->exists()) {
            return false;
        }

        try {
            Artisan::call('db:seed', ['--class' => RolePermissionSeeder::class, '--force' => true]);
            Artisan::call('db:seed', ['--class' => AdminUserSeeder::class, '--force' => true]);
        } catch (\Throwable $e) {
            report($e);

            return false;
        }

        return User::query()->where('email', 'admin@lyovial.com')->exists();
    }
}
