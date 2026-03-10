/* script for delete.php */
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search_name');
    const searchBtn   = document.getElementById('searchBtn');
    const resultsArea = document.getElementById('searchResults');
    const feedbackEl  = document.getElementById('deleteFeedback');


    if (!searchBtn) return;


    // Feedback helpers

    function showFeedback(message, type) {
        feedbackEl.textContent = message;
        feedbackEl.className   = 'alert alert-' + type;
    }

    function hideFeedback() {
        feedbackEl.className   = 'alert hidden';
        feedbackEl.textContent = '';
    }


    // 1. Search

    async function searchUsers() {
        const q = searchInput?.value.trim();

        if (!q) {
            searchInput?.focus();
            return;
        }

        hideFeedback();
        resultsArea.innerHTML = '<p class="loading-msg">Searching...</p>';

        try {
            const response = await fetch(
                url+'/?action=userSearch&q=' + encodeURIComponent(q),
                { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
            );

            const data = await response.json();

            if (!data.success) {
                resultsArea.innerHTML = '';
                showFeedback(data.message || 'Search failed.', 'error');
                return;
            }

            renderResults(data.users || []);

        } catch (err) {
            resultsArea.innerHTML = '';
            showFeedback('Request failed: ' + err.message, 'error');
        }
    }

    // 2. Render search results


    function renderResults(users) {
        if (!users.length) {
            resultsArea.innerHTML = '<p class="empty-msg">No users found.</p>';
            return;
        }

        const rows = users.map(function (u) {
            return `
                <tr id="row-${u.id}">
                    <td>${escHtml(u.name)}</td>
                    <td>${escHtml(u.email)}</td>
                    <td>
                        <button class="tbl-action danger"
                                data-id="${u.id}"
                                data-name="${escHtml(u.name)}">
                            Delete
                        </button>
                    </td>
                </tr>`;
        }).join('');

        resultsArea.innerHTML = `
            <div class="card table-card mt">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>`;

        // Attach delete listener to each button
        resultsArea.querySelectorAll('button[data-id]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                confirmDelete(btn.dataset.id, btn.dataset.name);
            });
        });
    }

    // 3. Confirm + Delete

    function confirmDelete(userId, userName) {
        const confirmed = window.confirm(
            'Are you sure you want to delete "' + userName + '"? This cannot be undone.'
        );
        if (confirmed) {
            deleteUser(userId, userName);
        }
    }

    async function deleteUser(userId, userName) {
        hideFeedback();

        const row = document.getElementById('row-' + userId);
        if (row) row.style.opacity = '0.4';

        try {
            const formData = new FormData();
            formData.append('id', userId);

            const response = await fetch(url+'/?action=delete', {
                method:  'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body:    formData,
            });

            const data = await response.json();

            if (data.success) {
                row?.remove();
                showFeedback(data.message || '"' + userName + '" was deleted successfully.', 'success');
            } else {
                if (row) row.style.opacity = '1';
                showFeedback(data.message || 'Delete failed.', 'error');
            }

        } catch (err) {
            if (row) row.style.opacity = '1';
            showFeedback('Request failed: ' + err.message, 'error');
        }
    }

    // Event listeners

    searchBtn.addEventListener('click', searchUsers);

    searchInput?.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchUsers();
        }
    });

    // Utility: escape HTML to prevent XSS in rendered results

    function escHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

});