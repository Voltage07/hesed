<?php
require __DIR__."/../../config/url.php";
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';

$users = $users ?? [];
?>

<main class="main-content">

    <div class="page-header">
        <h1 class="page-title">Users</h1>
        <p class="page-subtitle">All registered users.</p>
    </div>

    <div class="search-row">
        <input type="text"
               id="userSearch"
               class="search-input"
               placeholder="Search by name or email..."
               autocomplete="off" />
        <span class="search-count" id="searchCount">
            <?= count($users) ?> user<?= count($users) !== 1 ? 's' : '' ?>
        </span>
    </div>

    <div class="card table-card">
        <?php if (empty($users)): ?>
            <p class="empty-msg">No users registered yet.</p>
        <?php else: ?>
            <table class="data-table" id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <?php foreach ($users as $i => $user): ?>
                    <tr data-search="<?= strtolower(htmlspecialchars($user['name'])) ?>">
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <a href="<?= $base ?>/?page=delete" class="tbl-action danger">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="empty-msg hidden" id="noResults">No users match your search.</p>
        <?php endif; ?>
    </div>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script>
    const url = "<?= $base ?>";
</script>
<script src="<?= $base ?>/assets/js/users/users.js"></script>