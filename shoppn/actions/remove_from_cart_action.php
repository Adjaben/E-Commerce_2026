<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/cart.php'));
}

$ids = $_POST['remove'] ?? [];

if (!is_array($ids) || empty($ids)) {
    $_SESSION['cart_flash'] = ['type' => 'error', 'text' => 'Tick at least one item to remove.'];
    redirect(base_url('views/cart.php'));
}

$cart    = new CartController();
$ip      = get_ip();
$removed = 0;

foreach ($ids as $rawId) {
    $id = filter_var($rawId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    if ($id && $cart->removeFromCart($id, $ip)) {
        $removed++;
    }
}

$_SESSION['cart_flash'] = $removed > 0
    ? ['type' => 'success', 'text' => 'Removed from your cart.']
    : ['type' => 'error', 'text' => 'Could not remove the selected items.'];

redirect(base_url('views/cart.php'));