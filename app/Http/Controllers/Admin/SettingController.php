<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(protected SettingService $settingService) {}

    public function edit(?string $group = 'general'): View
    {
        $groups = ['general', 'contact', 'social', 'seo', 'analytics', 'scripts'];
        $group = in_array($group, $groups, true) ? $group : 'general';

        return view('admin.settings.edit', [
            'groups' => $groups,
            'group' => $group,
            'settings' => $this->settingService->allGrouped(),
        ]);
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $group = $request->validated('group');
        $data = collect($request->validated())->except('group')->filter(fn ($value) => $value !== null)->all();

        $fileKeys = match ($group) {
            'general' => ['logo', 'favicon'],
            'seo' => ['default_og_image', 'organization_logo', 'default_twitter_image'],
            default => [],
        };

        $this->settingService->updateGroup($group, array_merge($data, $request->allFiles()), $fileKeys);

        return back()->with('success', ucfirst($group).' settings updated successfully.');
    }
}
