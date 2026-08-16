<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\ContactInquiryController;
use App\Http\Controllers\Admin\ContactPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SeoRedirectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WhyChooseItemController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix(config('admin.prefix', 'admin'))
    ->name('admin.')
    ->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('login', [LoginController::class, 'login'])->name('login.submit');

            Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
            Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

            Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
            Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
        });

        Route::middleware(['auth', 'admin.active'])->group(function () {
            Route::post('logout', [LoginController::class, 'logout'])->name('logout');

            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

            Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

            Route::post('theme', [ThemeController::class, 'update'])->name('theme.update');

            Route::get('settings', [SettingController::class, 'edit'])->middleware('permission:settings.manage')->name('settings.edit');
            Route::put('settings', [SettingController::class, 'update'])->middleware('permission:settings.manage')->name('settings.update');

            Route::middleware('permission:settings.manage')->prefix('seo-redirects')->name('seo-redirects.')->group(function () {
                Route::get('/', [SeoRedirectController::class, 'index'])->name('index');
                Route::post('/', [SeoRedirectController::class, 'store'])->name('store');
                Route::put('{seo_redirect}', [SeoRedirectController::class, 'update'])->name('update');
                Route::delete('{seo_redirect}', [SeoRedirectController::class, 'destroy'])->name('destroy');
            });

            Route::middleware('permission:media.manage')->group(function () {
                Route::get('media', [MediaController::class, 'index'])->name('media.index');
                Route::post('media', [MediaController::class, 'store'])->name('media.store');
                Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
                Route::post('media/{media}/replace', [MediaController::class, 'replace'])->name('media.replace');
                Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
                Route::post('media/editor-upload', [MediaController::class, 'uploadEditor'])->name('media.editor-upload');
            });

            Route::middleware('permission:files.manage')->group(function () {
                Route::get('files', [FileManagerController::class, 'index'])->name('files.index');
                Route::post('files', [FileManagerController::class, 'store'])->name('files.store');
                Route::delete('files/{file}', [FileManagerController::class, 'destroy'])->name('files.destroy');
            });

            Route::middleware('permission:pages.view|pages.create|pages.update|pages.delete')->group(function () {
                Route::resource('pages', PageController::class)->except(['show']);
            });

            Route::middleware('permission:services.view|services.create|services.update|services.delete')->group(function () {
                Route::resource('services', ServiceController::class)->except(['show']);
            });

            Route::middleware('permission:industries.view|industries.create|industries.update|industries.delete')->group(function () {
                Route::resource('industries', IndustryController::class)->except(['show']);
            });

            Route::middleware('permission:home.manage')->group(function () {
                Route::get('home', [HomeSectionController::class, 'index'])->name('home.index');
                Route::get('home/{key}/edit', [HomeSectionController::class, 'edit'])->name('home.edit');
                Route::put('home/{key}', [HomeSectionController::class, 'update'])->name('home.update');
            });

            Route::middleware('permission:why_choose.manage')->group(function () {
                Route::resource('why-choose', WhyChooseItemController::class)
                    ->parameters(['why-choose' => 'whyChooseItem'])
                    ->except(['show']);
            });

            Route::middleware('permission:testimonials.manage')->group(function () {
                Route::resource('testimonials', TestimonialController::class)->except(['show']);
            });

            Route::middleware('permission:articles.manage')->group(function () {
                Route::resource('articles', ArticleController::class)->except(['show']);
            });

            Route::middleware('permission:faqs.manage')->group(function () {
                Route::resource('faqs', FaqController::class)->except(['show']);
            });

            Route::middleware('permission:contact.manage')->group(function () {
                Route::get('contact', [ContactPageController::class, 'edit'])->name('contact.edit');
                Route::put('contact', [ContactPageController::class, 'update'])->name('contact.update');
            });

            Route::middleware('permission:inquiries.view|inquiries.manage')->group(function () {
                Route::get('inquiries', [ContactInquiryController::class, 'index'])->name('inquiries.index');
                Route::get('inquiries/export', [ContactInquiryController::class, 'exportCsv'])->middleware('permission:inquiries.export')->name('inquiries.export');
                Route::get('inquiries/{inquiry}', [ContactInquiryController::class, 'show'])->name('inquiries.show');
                Route::put('inquiries/{inquiry}', [ContactInquiryController::class, 'update'])->middleware('permission:inquiries.manage')->name('inquiries.update');
                Route::post('inquiries/{inquiry}/read', [ContactInquiryController::class, 'markRead'])->name('inquiries.mark-read');
                Route::post('inquiries/{inquiry}/unread', [ContactInquiryController::class, 'markUnread'])->name('inquiries.mark-unread');
                Route::delete('inquiries/{inquiry}', [ContactInquiryController::class, 'destroy'])->middleware('permission:inquiries.delete')->name('inquiries.destroy');

                Route::get('newsletter', [NewsletterSubscriberController::class, 'index'])->name('newsletter.index');
                Route::delete('newsletter/{subscriber}', [NewsletterSubscriberController::class, 'destroy'])->middleware('permission:inquiries.manage')->name('newsletter.destroy');
            });

            Route::middleware('permission:menus.manage')->group(function () {
                Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
                Route::post('menus', [MenuController::class, 'store'])->name('menus.store');
                Route::put('menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
                Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
                Route::post('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
            });
        });
    });
