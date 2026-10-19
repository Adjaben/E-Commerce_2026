<?php

require_once __DIR__ . '/../../controllers/CartController.php';

$cartHeaderController = new CartController();
$cartHeaderIp    = get_ip();
$cartHeaderCount = $cartHeaderController->getCartCount($cartHeaderIp);
$cartHeaderTotal = $cartHeaderController->getCartTotal($cartHeaderIp);

$cartFlash = $_SESSION['cart_flash'] ?? null;
unset($_SESSION['cart_flash']);
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
    <input type="text" name="user_query" placeholder="Search products...">
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

        <a class="cart-icon" href="<?= base_url('views/cart.php') ?>" aria-label="Go to cart">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <?php if ($cartHeaderCount > 0): ?>
                <span class="cart-badge"><?= (int) $cartHeaderCount ?></span>
            <?php endif; ?>
        </a>
    </nav>
</header>
<div class="cart-bar">
    <span>Shopping Cart — Total Items: <?= (int) $cartHeaderCount ?> | Total Price: GH₵ <?= number_format($cartHeaderTotal, 2) ?></span>
    <a href="<?= base_url('views/cart.php') ?>">Go to Cart</a>
</div>
<?php if ($cartFlash): ?>
    <p class="cart-flash <?= $cartFlash['type'] === 'success' ? 'success' : 'error' ?>"><?= htmlspecialchars($cartFlash['text']) ?></p>
<?php endif; ?>
<main class="site-main">
