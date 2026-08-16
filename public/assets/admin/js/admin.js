(() => {
    const shell = document.querySelector('.admin-shell');
    const toggleBtns = document.querySelectorAll('[data-sidebar-toggle]');
    const backdrop = document.querySelector('.sidebar-backdrop');
    const themeForms = document.querySelectorAll('[data-theme-form]');

    const isDesktop = () => window.matchMedia('(min-width: 992px)').matches;

    const setSidebarCollapsed = (collapsed) => {
        if (!shell) return;
        shell.classList.toggle('sidebar-collapsed', collapsed);
        localStorage.setItem('lyovial.sidebarCollapsed', collapsed ? '1' : '0');
    };

    const openMobileSidebar = () => document.body.classList.add('sidebar-open');
    const closeMobileSidebar = () => document.body.classList.remove('sidebar-open');

    if (shell && localStorage.getItem('lyovial.sidebarCollapsed') === '1' && isDesktop()) {
        shell.classList.add('sidebar-collapsed');
    }

    toggleBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (isDesktop()) {
                setSidebarCollapsed(!shell.classList.contains('sidebar-collapsed'));
            } else if (document.body.classList.contains('sidebar-open')) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
        });
    });

    if (backdrop) {
        backdrop.addEventListener('click', closeMobileSidebar);
    }

    document.querySelectorAll('.admin-sidebar .nav-link').forEach((link) => {
        link.addEventListener('click', () => {
            if (!isDesktop()) closeMobileSidebar();
        });
    });

    themeForms.forEach((form) => {
        form.addEventListener('submit', () => {
            const theme = form.querySelector('input[name="theme"]')?.value;
            if (theme) {
                localStorage.setItem('lyovial.themeHint', theme);
            }
        });
    });

    // Persist theme hint for faster paint before auth theme loads
    const hint = localStorage.getItem('lyovial.themeHint');
    if (hint && !document.body.dataset.themeLocked) {
        // already applied server-side; hint only for next visit polish
    }

    // Gallery repeater
    document.querySelectorAll('[data-gallery-add]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const target = document.querySelector(btn.dataset.galleryAdd);
            if (!target) return;
            const index = target.querySelectorAll('[data-gallery-row]').length;
            const row = document.createElement('div');
            row.className = 'gallery-row';
            row.dataset.galleryRow = '';
            row.innerHTML = `
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Image</label>
                        <input type="file" name="galleries[${index}][image]" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="galleries[${index}][title]" class="form-control" placeholder="Title">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Alt text</label>
                        <input type="text" name="galleries[${index}][alt_text]" class="form-control" placeholder="Alt text">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Order</label>
                        <input type="number" name="galleries[${index}][sort_order]" class="form-control" value="${index}">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger w-100" data-gallery-remove title="Remove">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>`;
            target.appendChild(row);
        });
    });

    document.addEventListener('click', (e) => {
        const removeBtn = e.target.closest('[data-gallery-remove]');
        if (removeBtn) {
            removeBtn.closest('[data-gallery-row]')?.remove();
        }
    });

    // Confirm delete helpers already use onsubmit confirm()
    document.querySelectorAll('[data-confirm]').forEach((el) => {
        el.addEventListener('submit', (e) => {
            const msg = el.getAttribute('data-confirm') || 'Are you sure?';
            if (!window.confirm(msg)) {
                e.preventDefault();
            }
        });
    });
})();
