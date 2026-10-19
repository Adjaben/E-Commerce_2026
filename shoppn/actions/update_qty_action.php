<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/cart.php'));
}

$ids  = $_POST['update'] ?? [];
$qtys = $_POST['qty'] ?? [];

if (!is_array($ids) || !is_array($qtys) || empty($ids)) {
    redirect(base_url('views/cart.php'));
}

$cart    = new CartController();
$ip      = get_ip();
$invalid = 0;

foreach ($ids as $i => $rawId) {
    $id  = filter_var($rawId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $qty = filter_var($qtys[$i] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 99]]);

    if (!$id || !$qty) {
        $invalid++;
        continue;
    }

    $cart->updateQty($id, $qty, $ip);
}

$_SESSION['cart_flash'] = $invalid > 0
    ? ['type' => 'error', 'text' => 'Quantities must be whole numbers from 1 to 99. Valid changes were saved.']
    : ['type' => 'success', 'text' => 'Cart updated.'];

redirect(base_url('views/cart.php'));