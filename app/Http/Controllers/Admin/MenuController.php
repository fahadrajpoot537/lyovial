<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $location = $request->string('location', 'header')->toString();
        if (! in_array($location, ['header', 'footer'], true)) {
            $location = 'header';
        }

        $menus = Menu::query()
            ->location($location)
            ->with('parent')
            ->orderByRaw('CASE WHEN parent_id IS NULL THEN 0 ELSE 1 END')
            ->orderBy('sort_order')
            ->get();

        $parents = $menus->whereNull('parent_id')->values();

        return view('admin.menus.index', compact('menus', 'location', 'parents'));
    }

    public function store(MenuRequest $request): RedirectResponse
    {
        $menu = Menu::create($request->validated());

        return redirect()
            ->route('admin.menus.index', ['location' => $menu->location])
            ->with('success', 'Menu item created successfully.');
    }

    public function update(MenuRequest $request, Menu $menu): RedirectResponse
    {
        $menu->update($request->validated());

        return back()->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->children()->delete();
        $menu->delete();

        return back()->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:menus,id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
            'items.*.parent_id' => ['nullable', 'integer', 'exists:menus,id'],
        ]);

        foreach ($validated['items'] as $item) {
            Menu::query()->whereKey($item['id'])->update([
                'sort_order' => $item['sort_order'],
                'parent_id' => $item['parent_id'] ?? null,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Menu order updated successfully.');
    }
}
