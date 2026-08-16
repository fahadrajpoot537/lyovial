@if (isset($items) && method_exists($items, 'hasPages') && $items->hasPages())
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3 px-1">
        <div class="text-muted small">
            Showing {{ $items->firstItem() }}–{{ $items->lastItem() }} of {{ $items->total() }}
        </div>
        <div>
            {{ $items->withQueryString()->links() }}
        </div>
    </div>
@endif
