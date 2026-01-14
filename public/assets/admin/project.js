(function () {

    /* ===============================
       Search + AJAX Pagination
    ================================ */

    const input = document.getElementById('searchByName');
    const tbody = document.getElementById('categoriesTbody');
    const pagerBox = document.getElementById('categoriesPagination');

    if (typeof PROJECTS_INDEX_URL === 'undefined') return;

    let timer = null;

    function runSearch(url = PROJECTS_INDEX_URL) {
        const finalUrl = new URL(url, window.location.origin);

        const q = (input?.value || '').trim();
        if (q) finalUrl.searchParams.set('q', q);
        else finalUrl.searchParams.delete('q');

        input && (input.disabled = true);

        fetch(finalUrl.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                tbody && (tbody.innerHTML = data.rows);
                pagerBox && (pagerBox.innerHTML = data.pagination);
                history.replaceState({}, '', finalUrl);
            })
            .catch(() => console.error('Failed to load projects'))
            .finally(() => input && (input.disabled = false));
    }

    input?.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => runSearch(), 300);
    });

    document.addEventListener('click', e => {
        const link = e.target.closest('#categoriesPagination a');
        if (!link) return;

        e.preventDefault();
        runSearch(link.href);
    });

    /* ===============================
       Status Change
    ================================ */

    window.handleStatusChange = function (select) {

        const form = select.closest('form');
        const prev = select.dataset.prev;
        const newVal = select.value;

        const statuses = {
            draft: { class: 'secondary', label: 'مسودة' },
            pending: { class: 'warning', label: 'قيد المراجعة' },
            approved: { class: 'success', label: 'موافقة مبدئية' },
            funding: { class: 'info', label: 'مفتوح للاستثمار' },
            active: { class: 'primary', label: 'ممَوَّل بالكامل' },
            completed: { class: 'success', label: 'مرحلة السداد' },
            defaulted: { class: 'danger', label: 'متعثر' },
        };

        if (!confirm('هل أنت متأكد من تغيير حالة المشروع؟')) {
            select.value = prev;
            return;
        }

        const tr = select.closest('tr');
        const badge = tr.querySelector('.status-badge');

        if (badge && statuses[newVal]) {
            badge.className = 'status-badge ' + statuses[newVal].class;
            badge.textContent = statuses[newVal].label;
        }

        select.dataset.prev = newVal;
        form.submit();
    };

})();
