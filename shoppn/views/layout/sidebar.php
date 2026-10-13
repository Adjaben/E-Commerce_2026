<?php
require_once __DIR__ . '/../../controllers/ProductController.php';

$sidebarController = new ProductController();
$sidebarCategories = $sidebarController->getAllCategories();
$sidebarBrands     = $sidebarController->getAllBrands();
?>
<aside class="site-sidebar">
    <h3>Categories</h3>
    <ul>
        <?php foreach ($sidebarCategories as $cat): ?>
            <li><a href="<?= base_url('index.php?cat=' . (int) $cat['cat_id']) ?>"><?= htmlspecialchars($cat['cat_name']) ?></a></li>
        <?php endforeach; ?>
    </ul>

    <h3>Brands</h3>
    <ul>
        <?php foreach ($sidebarBrands as $brand): ?>
            <li><a href="<?= base_url('index.php?brand=' . (int) $brand['brand_id']) ?>"><?= htmlspecialchars($brand['brand_name']) ?></a></li>
        <?php endforeach; ?>
    </ul>
</aside>