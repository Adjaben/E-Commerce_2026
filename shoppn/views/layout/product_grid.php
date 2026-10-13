<?php
// Expects $products (an array). Shared by home.php and search_results.php.
?>
<?php if (empty($products)): ?>
    <p class="empty">No products found.</p>
<?php else: ?>
    <div class="product-grid">
        <?php foreach ($products as $p): ?>
            <div class="product-card">
                <?php if (!empty($p['product_image'])): ?>
                    <img src="<?= base_url('images/products/' . rawurlencode($p['product_image'])) ?>"
                         alt="<?= htmlspecialchars($p['product_title']) ?>">
                <?php endif; ?>
                <h3><?= htmlspecialchars($p['product_title']) ?></h3>
                <p class="price">GH₵ <?= number_format($p['product_price'], 2) ?></p>
                <div class="card-links">
                    <a href="<?= base_url('views/single_product.php?pro_id=' . (int) $p['product_id']) ?>">Details</a>
                    <a href="<?= base_url('index.php?add_cart=' . (int) $p['product_id']) ?>">Add to Cart</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>