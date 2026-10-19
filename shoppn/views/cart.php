<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$cartPageController = new CartController();
$items = $cartPageController->getCartItems(get_ip());
$total = $cartPageController->getCartTotal(get_ip());

require __DIR__ . '/layout/header.php';
?>

<div class="page page-cart">
    <h1>Your Cart</h1>

    <?php if (empty($items)): ?>
        <p class="empty">Your cart is empty.</p>
        <a class="btn" href="<?= base_url('index.php') ?>">Continue Shopping</a>
    <?php else: ?>

        <form id="remove-form" action="<?= base_url('actions/remove_from_cart_action.php') ?>" method="POST"></form>
        <form id="update-form" action="<?= base_url('actions/update_qty_action.php') ?>" method="POST"></form>

        <table class="cart-table">
            <thead>
                <tr><th>Remove</th><th>Product</th><th>Quantity</th><th>Unit Price</th></tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="remove[]" value="<?= (int) $item['p_id'] ?>" form="remove-form">
                    </td>
                    <td>
                        <div class="cart-product">
                            <?php if (!empty($item['product_image'])): ?>
                                <img src="<?= base_url('images/products/' . rawurlencode($item['product_image'])) ?>"
                                     alt="<?= htmlspecialchars($item['product_title']) ?>">
                            <?php endif; ?>
                            <span><?= htmlspecialchars($item['product_title']) ?></span>
                        </div>
                    </td>
                    <td>
                        <input type="number" name="qty[]" value="<?= (int) $item['qty'] ?>" min="1" max="99" form="update-form">
                        <input type="hidden" name="update[]" value="<?= (int) $item['p_id'] ?>" form="update-form">
                    </td>
                    <td>GH₵ <?= number_format($item['product_price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
                <tr class="subtotal-row">
                    <td colspan="3">Subtotal</td>
                    <td>GH₵ <?= number_format($total, 2) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="cart-actions">
            <button class="btn" type="submit" form="remove-form">Remove from Cart</button>
            <button class="btn" type="submit" form="update-form">Update Quantity</button>
            <a class="btn btn-outline" href="<?= base_url('index.php') ?>">Continue Shopping</a>
            <a class="btn" href="<?= base_url('views/checkout.php') ?>">Checkout</a>
        </div>

    <?php endif; ?>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>