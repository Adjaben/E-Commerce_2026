<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$id = filter_var($_GET['pro_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id) {
    redirect(base_url('index.php'));
}

$controller = new ProductController();
$product = $controller->getProductById($id);
if (!$product) {
    redirect(base_url('index.php'));
}

require __DIR__ . '/layout/header.php';
?>

<div class="page page-single-product">
    <div class="single-product">
        <?php if (!empty($product['product_image'])): ?>
            <img src="<?= base_url('images/products/' . rawurlencode($product['product_image'])) ?>"
                 alt="<?= htmlspecialchars($product['product_title']) ?>">
        <?php endif; ?>

        <div class="single-product-info">
            <h1><?= htmlspecialchars($product['product_title']) ?></h1>
            <p class="price">GH₵ <?= number_format($product['product_price'], 2) ?></p>
            <p><strong>Category:</strong> <?= htmlspecialchars($product['cat_name'] ?? '') ?></p>
            <p><strong>Brand:</strong> <?= htmlspecialchars($product['brand_name'] ?? '') ?></p>
            <p><?= nl2br(htmlspecialchars($product['product_desc'] ?? '')) ?></p>
            <p><strong>Keywords:</strong> <?= htmlspecialchars($product['product_keywords'] ?? '') ?></p>
            <a class="btn" href="<?= base_url('index.php?add_cart=' . (int) $product['product_id']) ?>">Add to Cart</a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>