<?php
require_once __DIR__ . '/../controllers/ProductController.php';
$controller = new ProductController();

$heading = 'Featured Products';

if (isset($_GET['cat'])) {
    $catId = filter_var($_GET['cat'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $products = $catId ? $controller->getProductsByCategory($catId) : [];
    $heading = 'Products by Category';
} elseif (isset($_GET['brand'])) {
    $brandId = filter_var($_GET['brand'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $products = $brandId ? $controller->getProductsByBrand($brandId) : [];
    $heading = 'Products by Brand';
} else {
    $products = $controller->getFeaturedProducts();
}

require __DIR__ . '/layout/header.php';
?>

<?php if (!isset($_GET['cat']) && !isset($_GET['brand'])): ?>
    <section class="hero">
        <p>Thoughtfully chosen products, simply presented.</p>
        <a class="btn" href="#products">Shop now</a>
        <h1>Shoppn</h1>
    </section>
<?php endif; ?>

<div class="layout">
    <?php require __DIR__ . '/layout/sidebar.php'; ?>

    <div class="page page-home" id="products">
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <h1><?= htmlspecialchars($heading) ?></h1>
        <?php require __DIR__ . '/layout/product_grid.php'; ?>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>