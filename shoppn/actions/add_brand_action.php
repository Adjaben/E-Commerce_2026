<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/admin/brand.php'));
}

$name = trim(strip_tags($_POST['brand_name'] ?? ''));

if ($name === '' || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a valid brand name.';
    redirect(base_url('views/admin/brand.php'));
}

$controller = new ProductController();
$newId = $controller->addBrand($name);

if ($newId === false) {
    $_SESSION['error'] = 'Could not add brand. Please try again.';
} else {
    $_SESSION['success'] = 'Brand added.';
}

redirect(base_url('views/admin/brand.php'));
