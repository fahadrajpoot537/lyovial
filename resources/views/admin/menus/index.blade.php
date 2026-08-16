@extends('admin.layouts.app')

@section('title', 'Menus')

@section('content')
    @php
        $menus = $menus ?? $items ?? collect();
        $location = $location ?? request('location', 'header');
        $parents = $parents ?? $menus->whereNull('parent_id');
    @endphp

    <div class="page-header">
        <div>
            <h1>Menus</h1>
            <p class="subtitle">Navigation items and order</p>
        </div>
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $location === 'header' ? 'active' : '' }}" href="{{ route('admin.menus.index', ['location' => 'header']) }}">Header</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $location === 'footer' ? 'active' : '' }}" href="{{ route('admin.menus.index', ['location' => 'footer']) }}">Footer</a>
        </li>
    </ul>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card card-admin">
                <div class="card-header">Add menu item</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.menus.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="url">URL</label>
                            <input type="text" name="url" id="url" class="form-control" value="{{ old('url') }}" placeholder="/about">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="route_name">Route name</label>
                            <input type="text" name="route_name" id="route_name" class="form-control" value="{{ old('route_name') }}" placeholder="optional">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="location">Location</label>
                            <select name="location" id="location" class="form-select">
                                <option value="header" @selected(old('location', $location) === 'header')>Header</option>
                                <option value="footer" @selected(old('location', $location) === 'footer')>Footer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="parent_id">Parent</label>
                            <select name="parent_id" id="parent_id" class="form-select">
                                <option value="">— None —</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>{{ $parent->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="target">Target</label>
                            <select name="target" id="target" class="form-select">
                                <option value="_self" @selected(old('target', '_self') === '_self')>_self</option>
                                <option value="_blank" @selected(old('target') === '_blank')>_blank</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="css_class">CSS class</label>
                            <input type="text" name="css_class" id="css_class" class="form-control" value="{{ old('css_class') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="icon">Icon</label>
                            <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="sort_order">Sort order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true))>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input type="hidden" name="open_in_new_tab" value="0">
                            <input class="form-check-input" type="checkbox" name="open_in_new_tab" id="open_in_new_tab" value="1" @checked(old('open_in_new_tab'))>
                            <label class="form-check-label" for="open_in_new_tab">Open in new tab</label>
                        </div>
                        <button type="submit" class="btn btn-teal w-100">Add item</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-admin">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Menu items</span>
                    <form method="POST" action="{{ route('admin.menus.reorder') }}" id="reorderForm" class="d-flex gap-2 align-items-center">
                        @csrf
                        <div id="menuOrderFields"></div>
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Save order</button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-admin mb-0">
                            <thead>
                                <tr>
                                    <th style="width:90px">Order</th>
                                    <th>Title</th>
                                    <th>Parent</th>
                                    <th>Location</th>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="menuSortable">
                                @forelse ($menus as $menu)
                                    <tr data-id="{{ $menu->id }}">
                                        <td>
                                            <input type="number" class="form-control form-control-sm menu-order-input"
                                                   value="{{ $menu->sort_order }}" data-id="{{ $menu->id }}" min="0" style="width:70px">
                                        </td>
                                        <td class="fw-semibold">{{ $menu->parent_id ? '— '.$menu->title : $menu->title }}</td>
                                        <td class="text-muted small">{{ $menu->parent?->title ?: '—' }}</td>
                                        <td><span class="badge badge-soft-secondary">{{ $menu->location }}</span></td>
                                        <td class="small text-truncate" style="max-width:160px">{{ $menu->url ?: $menu->route_name ?: '—' }}</td>
                                        <td>
                                            @if ($menu->is_active)
                                                <span class="badge badge-soft">Active</span>
                                            @else
                                                <span class="badge badge-soft-secondary">Off</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-toggle="modal" data-bs-target="#editMenuModal"
                                                    data-url="{{ route('admin.menus.update', $menu) }}"
                                                    data-title="{{ $menu->title }}"
                                                    data-url-value="{{ $menu->url }}"
                                                    data-route="{{ $menu->route_name }}"
                                                    data-location="{{ $menu->location }}"
                                                    data-parent="{{ $menu->parent_id }}"
                                                    data-target="{{ $menu->target }}"
                                                    data-class="{{ $menu->css_class }}"
                                                    data-icon="{{ $menu->icon }}"
                                                    data-order="{{ $menu->sort_order }}"
                                                    data-active="{{ $menu->is_active ? '1' : '0' }}"
                                                    data-newtab="{{ $menu->open_in_new_tab ? '1' : '0' }}">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" class="d-inline" onsubmit="return confirm('Delete this menu item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="empty-state">
                                            <i class="bi bi-list-nested d-block mb-2"></i>
                                            No menu items yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editMenuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="editMenuForm" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit menu item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="edit_menu_title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="text" name="url" id="edit_menu_url" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Route name</label>
                        <input type="text" name="route_name" id="edit_menu_route" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <select name="location" id="edit_menu_location" class="form-select">
                            <option value="header">Header</option>
                            <option value="footer">Footer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent</label>
                        <select name="parent_id" id="edit_menu_parent" class="form-select">
                            <option value="">— None —</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Target</label>
                        <select name="target" id="edit_menu_target" class="form-select">
                            <option value="_self">_self</option>
                            <option value="_blank">_blank</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">CSS class</label>
                        <input type="text" name="css_class" id="edit_menu_class" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" name="icon" id="edit_menu_icon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sort order</label>
                        <input type="number" name="sort_order" id="edit_menu_order" class="form-control">
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="edit_menu_active" value="1">
                        <label class="form-check-label" for="edit_menu_active">Active</label>
                    </div>
                    <div class="form-check form-switch">
                        <input type="hidden" name="open_in_new_tab" value="0">
                        <input class="form-check-input" type="checkbox" name="open_in_new_tab" id="edit_menu_newtab" value="1">
                        <label class="form-check-label" for="edit_menu_newtab">Open in new tab</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-teal">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(() => {
    const orderForm = document.getElementById('reorderForm');
    const orderFields = document.getElementById('menuOrderFields');

    orderForm?.addEventListener('submit', () => {
        if (!orderFields) return;
        orderFields.innerHTML = '';
        [...document.querySelectorAll('#menuSortable tr[data-id]')].forEach((row, index) => {
            const id = row.dataset.id;
            const sort = row.querySelector('.menu-order-input')?.value || index;
            orderFields.insertAdjacentHTML('beforeend',
                `<input type="hidden" name="items[${index}][id]" value="${id}">` +
                `<input type="hidden" name="items[${index}][sort_order]" value="${sort}">`
            );
        });
    });

    document.getElementById('editMenuModal')?.addEventListener('show.bs.modal', (event) => {
        const btn = event.relatedTarget;
        const form = document.getElementById('editMenuForm');
        form.action = btn.getAttribute('data-url');
        form.querySelector('#edit_menu_title').value = btn.getAttribute('data-title') || '';
        form.querySelector('#edit_menu_url').value = btn.getAttribute('data-url-value') || '';
        form.querySelector('#edit_menu_route').value = btn.getAttribute('data-route') || '';
        form.querySelector('#edit_menu_location').value = btn.getAttribute('data-location') || 'header';
        form.querySelector('#edit_menu_parent').value = btn.getAttribute('data-parent') || '';
        form.querySelector('#edit_menu_target').value = btn.getAttribute('data-target') || '_self';
        form.querySelector('#edit_menu_class').value = btn.getAttribute('data-class') || '';
        form.querySelector('#edit_menu_icon').value = btn.getAttribute('data-icon') || '';
        form.querySelector('#edit_menu_order').value = btn.getAttribute('data-order') || 0;
        form.querySelector('#edit_menu_active').checked = btn.getAttribute('data-active') === '1';
        form.querySelector('#edit_menu_newtab').checked = btn.getAttribute('data-newtab') === '1';
    });
})();
</script>
@endpush
