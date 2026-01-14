// public/assets/admin/categories.js
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchByName');
    const tbody = document.getElementById('categoriesTbody');
    const pagination = document.getElementById('categories-pagination');

    if (!searchInput || !tbody) return;

    // Debounce function to limit API calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Search function
    const performSearch = debounce(function(searchTerm) {
        const url = searchInput.dataset.searchUrl;
        const params = new URLSearchParams();
        params.append('q', searchTerm);

        fetch(`${url}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            tbody.innerHTML = data.html;
            // Update pagination if needed
            if (data.pagination) {
                pagination.innerHTML = data.pagination;
            }
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    }, 300);

    // Bind search input
    searchInput.addEventListener('input', function(e) {
        performSearch(e.target.value);
    });

    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('#categories-pagination a')) {
            e.preventDefault();
            const link = e.target.closest('#categories-pagination a');
            const url = new URL(link.href);
            const searchTerm = searchInput.value || '';
            url.searchParams.set('q', searchTerm);

            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                tbody.innerHTML = data.html;
                pagination.innerHTML = data.pagination || '';
            })
            .catch(error => {
                console.error('Pagination error:', error);
            });
        }
    });
});
