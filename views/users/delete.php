<?php
/* logic is handled by delete.js via fetch. */
require __DIR__."/../../config/url.php";
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
?>

<main class="main-content">

    <div class="page-header">
        <h1 class="page-title">Delete User</h1>
        <p class="page-subtitle">Search for a user by name or email, then remove them from the system.</p>
    </div>

    <!-- delete.js injects success / error messages here -->
    <div id="deleteFeedback" class="alert hidden"></div>

    <div class="card form-card">
        <h2 class="card-heading">Find User</h2>
        <div class="form-group">
            <label for="search_name">Name or Email</label>
            <div class="input-with-btn">
                <input type="text"
                       id="search_name"
                       placeholder="Enter name or email..."
                       autocomplete="off" />
                <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>

    <!-- delete.js renders search results here -->
    <div id="searchResults"></div>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script>
    const url = "<?= $base ?>";
</script>
<script src="<?= $base ?>/assets/js/users/delete.js"></script>