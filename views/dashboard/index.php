<?php
// default page
require __DIR__."/../../config/url.php";
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/sidebar.php';
?>

<main class="main-content">

    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Overview of your user data.</p>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <p class="stat-label">Total Users</p>
            <p class="stat-value"><?= (int) $stats['total'] ?></p>
        </div>
    </div>

    <div class="card mt">
        <h2 class="card-heading">Quick Actions</h2>
        <div class="btn-row">
            <a href="<?= $base ?>/?page=create" class="btn btn-primary">Register New User</a>
            <a href="<?= $base ?>/?page=users"  class="btn btn-outline">View All Users</a>
        </div>
    </div>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>