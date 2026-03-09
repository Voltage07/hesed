<?php
/**
 * views/layout/footer.php
 *
 * Closes the page-wrapper opened in header.php,
 * renders the footer bar, and loads JavaScript.
 * Always include this last.
 */
require __DIR__."/../../config/url.php";
?>

</div><!-- /.page-wrapper -->

<footer class="site-footer">
    <p>&copy; <?= date('Y') ?></p>
</footer>

<script src="<?= $base ?>/assets/js/main.js"></script>

</body>
</html>