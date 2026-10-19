<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$productId = filter_var($_GET['add_cart'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if (!$productId || !(new ProductController())->getProductById($productId)) {
    $_SESSION['cart_flash'] = ['type' => 'error', 'text' => 'That product could not be found.'];
    redirect_back();
}

$ip   = get_ip();
$cart = new CartController();

if ($cart->isInCart($productId, $ip)) {
    $_SESSION['cart_flash'] = [
        'type' => 'error',
        'text' => 'This item is already in your cart. Go to cart to update quantity.',
    ];
    redirect_back();
}

$customerId = $_SESSION['customer_id'] ?? null;

if ($cart->addToCart($productId, 1, $ip, $customerId)) {
    $_SESSION['cart_flash'] = ['type' => 'success', 'text' => 'Item added to your cart.'];
} else {
    $_SESSION['cart_flash'] = ['type' => 'error', 'text' => 'Could not add the item. Please try again.'];
}

redirect_back();