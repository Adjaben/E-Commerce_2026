<?php
// views/layout/header.php
// View layer. Included at the top of every page. Only session-based
// display logic here (e.g. which nav links to show) — no SQL.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<header class="site-header">
    <a class="logo" href="<?= base_url('index.php') ?>">Shoppn</a>

    <form class="search-bar" action="<?= base_url('views/search_results.php') ?>" method="GET">
        <input type="text" name="q" placeholder="Search products...">
        <button type="submit">Search</button>
    </form>

    <nav class="site-nav">
        <?php if (is_logged_in()): ?>
            <span>Welcome, <?= htmlspecialchars($_SESSION['customer_name']) ?></span>
            <a href="<?= base_url('views/account/my_account.php') ?>">My Account</a>
            <?php if (is_admin()): ?>
                <a href="<?= base_url('views/admin/index.php') ?>">Actions</a>
<?php endif; ?>
            <a href="<?= base_url('logout.php') ?>">Logout</a>
        <?php else: ?>
            <a href="<?= base_url('views/register.php') ?>">Register</a>
            <a href="<?= base_url('views/login.php') ?>">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main class="site-main">
