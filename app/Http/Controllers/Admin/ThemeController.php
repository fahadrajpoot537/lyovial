<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ThemeRequest;
use Illuminate\Http\RedirectResponse;

class ThemeController extends Controller
{
    public function update(ThemeRequest $request): RedirectResponse
    {
        $request->user()->update([
            'theme' => $request->validated('theme'),
        ]);

        return back()->with('success', 'Theme updated successfully.');
    }
}
