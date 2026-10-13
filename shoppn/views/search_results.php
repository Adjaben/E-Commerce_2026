<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$query = trim(strip_tags($_GET['user_query'] ?? ''));

$controller = new ProductController();
$products = $query !== '' ? $controller->searchProducts($query) : [];

require __DIR__ . '/layout/header.php';
?>

<div class="layout">
    <?php require __DIR__ . '/layout/sidebar.php'; ?>

    <div class="page page-search">
        <h1>Search results<?= $query !== '' ? ' for "' . htmlspecialchars($query) . '"' : '' ?></h1>
        <?php require __DIR__ . '/layout/product_grid.php'; ?>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>