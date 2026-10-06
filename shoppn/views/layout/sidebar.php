<?php
// views/layout/sidebar.php
// View layer. No SQL here — it calls ProductController and just loops
// over what comes back.

require_once __DIR__ . '/../../controllers/ProductController.php';

$productController = new ProductController();
$categories = $productController->getSidebarCategories();
$brands     = $productController->getSidebarBrands();
?>
<aside class="site-sidebar"> 
   <h3>Categories</h3>
    <ul>
        <?php foreach ($categories as $cat): ?>
            <li><a href="<?= base_url('views/all_products.php?cat=' . urlencode($cat['cat_id'])) ?>">
                <?= htmlspecialchars($cat['cat_name']) ?>
            </a></li>
        <?php endforeach; ?>
    </ul> 

    <h3>Brands</h3>
    <ul>
        <?php foreach ($brands as $brand): ?>
            <li><a href="<?= base_url('views/all_products.php?brand=' . urlencode($brand['brand_id'])) ?>">
                <?= htmlspecialchars($brand['brand_name']) ?>
            </a></li>
        <?php endforeach; ?>
    </ul>
</aside>
