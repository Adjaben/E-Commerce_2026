<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/admin/product.php'));
}

$id       = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$cat      = filter_var($_POST['product_cat'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$brand    = filter_var($_POST['product_brand'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$title    = trim(strip_tags($_POST['product_title'] ?? ''));
$price    = filter_var($_POST['product_price'] ?? null, FILTER_VALIDATE_FLOAT);
$desc     = trim(strip_tags($_POST['product_desc'] ?? ''));
$keywords = trim(strip_tags($_POST['product_keywords'] ?? ''));

if (!$id) {
    $_SESSION['error'] = 'Invalid product.';
    redirect(base_url('views/admin/product.php'));
}

if (!$cat || !$brand || $title === '' || strlen($title) > 150 || $price === false || $price < 0 || strlen($keywords) > 255) {
    $_SESSION['error'] = 'Please fill in all fields correctly.';
    redirect(base_url('views/admin/product.php?edit_id=' . $id));
}

// Keep the existing image (hidden field) unless a new one was uploaded.
// basename() strips any path so a tampered hidden field can't point outside images/products/.
$filename = basename($_POST['existing_image'] ?? '');
$file = $_FILES['product_image'] ?? null;

if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
    $upload = upload_product_image($file);

    if (!$upload['ok']) {
        $_SESSION['error'] = $upload['error'];
        redirect(base_url('views/admin/product.php?edit_id=' . $id));
    }

    $filename = $upload['filename'];
}

$controller = new ProductController();
$success = $controller->updateProduct($id, $cat, $brand, $title, $price, $desc, $filename, $keywords);

$_SESSION[$success ? 'success' : 'error'] = $success ? 'Product updated.' : 'Could not update product.';

redirect(base_url('views/admin/product.php'));