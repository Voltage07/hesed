<?php
/**
 * views/layout/sidebar.php
 *
 * Left navigation sidebar.
 * Include this right after header.php.
 *
 * Expects before including:
 *   $currentPage (string) — 'dashboard' | 'create' | 'users' | 'delete'
 */
require __DIR__."/../../config/url.php";

$currentPage = $currentPage ?? 'dashboard';

$navItems = [
    'dashboard' => ['label' => 'Dashboard',    'href' => $base . '/'],
    'create'    => ['label' => 'Register User', 'href' =>  $base . '/?page=create'],
    'users'     => ['label' => 'View Users',    'href' => $base .'/?page=users'],
    'delete'    => ['label' => 'Delete User',   'href' => $base .'/?page=delete'],
];
?>

<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <img src="<?= $base ?>/assets/images/logo.png"
             alt="Logo"
             class="sidebar-logo"
             onerror="this.style.display='none'" />
        <span class="sidebar-brand-text">HESED</span>
    </div>

    <nav class="sidebar-nav">
        <p class="sidebar-section-label">Menu</p>

        <?php foreach ($navItems as $key => $item): ?>
        <a href="<?= $item['href'] ?>"
           class="sidebar-link <?= $currentPage === $key ? 'active' : '' ?>">
            <?= $item['label'] ?>
        </a>
        <?php endforeach; ?>
    </nav>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>