<?php
/*Submission is handled by create.js via fetch*/
require __DIR__."/../../config/url.php";
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
?>

<main class="main-content">

    <div class="page-header">
        <h1 class="page-title">Register User</h1>
        <p class="page-subtitle">Add a new user to the system.</p>
    </div>

    <div id="formFeedback" class="alert hidden"></div>

    <div class="card form-card">
        <form id="createUserForm"
              method="POST"
              action="<?= $base ?>/?action=create"
              novalidate>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text"
                       id="name"
                       name="name"
                       placeholder="e.g. John Doe"
                       autocomplete="off"
                       required />
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email"
                       id="email"
                       name="email"
                       placeholder="user@example.com"
                       autocomplete="off"
                       required />
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Register User</button>
                <button type="reset"  class="btn btn-outline">Clear</button>
            </div>

        </form>
    </div>

</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
<script>
    const url = "<?= $base ?>";
</script>
<script src="<?= $base ?>/assets/js/users/create.js"></script>