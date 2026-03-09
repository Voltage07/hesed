/**
 * assets/js/users/users.js
 *
 * Live search for the View Users page.
 * Filters table rows client-side as the user types — no fetch needed
 * because all users are already rendered in the PHP table.
 */

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('userSearch');
    const tableBody   = document.getElementById('usersTableBody');
    const countEl     = document.getElementById('searchCount');
    const noResults   = document.getElementById('noResults');

    if (!searchInput || !tableBody) return;

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim().toLowerCase();
        const rows  = tableBody.querySelectorAll('tr');
        let visible = 0;

        rows.forEach(function (row) {
            const name  = row.getAttribute('data-search') || '';
            const match = !query || name.includes(query);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        if (countEl) {
            countEl.textContent = visible + ' user' + (visible !== 1 ? 's' : '');
        }

        if (noResults) {
            noResults.classList.toggle('hidden', visible > 0);
        }
    });

});