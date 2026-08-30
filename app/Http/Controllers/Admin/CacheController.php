<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AppCache;
use Illuminate\Http\RedirectResponse;

class CacheController extends Controller
{
    public function clear(): RedirectResponse
    {
        AppCache::clear();

        return back()->with('success', 'Cache cleared. Homepage, routes, views, and config are fresh.');
    }
}
