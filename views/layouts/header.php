<?php
/**
 * views/layout/header.php
 *
 * Opens the HTML document, loads CSS, and renders the topbar.
 * Always include this first.
 *
 * Expects before including:
 *   $pageTitle   (string) — shown in <title> and topbar
 */
require __DIR__."/../../config/url.php";

$pageTitle = $pageTitle ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="<?= $base ?>/assets/css/style.css" />
</head>
<body>

<header class="topbar">
    <button class="topbar-menu-btn" id="menuToggle" aria-label="Toggle sidebar">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <span class="topbar-title"><?= htmlspecialchars($pageTitle) ?></span>

    <div class="topbar-right">
        <span class="topbar-user">Admin</span>
    </div>
</header>

<div class="page-wrapper">