<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/admin/product.php'));
}

$cat      = filter_var($_POST['product_cat'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$brand    = filter_var($_POST['product_brand'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$title    = trim(strip_tags($_POST['product_title'] ?? ''));
$price    = filter_var($_POST['product_price'] ?? null, FILTER_VALIDATE_FLOAT);
$desc     = trim(strip_tags($_POST['product_desc'] ?? ''));
$keywords = trim(strip_tags($_POST['product_keywords'] ?? ''));

if (!$cat || !$brand || $title === '' || strlen($title) > 150 || $price === false || $price < 0 || strlen($keywords) > 255) {
    $_SESSION['error'] = 'Please fill in all fields correctly.';
    redirect(base_url('views/admin/product.php'));
}

$upload = upload_product_image($_FILES['product_image'] ?? null);

if (!$upload['ok']) {
    $_SESSION['error'] = $upload['error'];
    redirect(base_url('views/admin/product.php'));
}

$controller = new ProductController();
$newId = $controller->addProduct($cat, $brand, $title, $price, $desc, $upload['filename'], $keywords);

if ($newId === false) {
    @unlink(__DIR__ . '/../images/products/' . $upload['filename']); // don't leave an orphaned image
    $_SESSION['error'] = 'Could not add product. Please try again.';
} else {
    $_SESSION['success'] = 'Product added.';
}

redirect(base_url('views/admin/product.php'));