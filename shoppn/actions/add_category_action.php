<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/admin/category.php'));
}

$name = trim(strip_tags($_POST['cat_name'] ?? ''));

if ($name === '' || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a valid category name.';
    redirect(base_url('views/admin/category.php'));
}

$controller = new ProductController();
$newId = $controller->addCategory($name);

if ($newId === false) {
    $_SESSION['error'] = 'Could not add category. Please try again.';
} else {
    $_SESSION['success'] = 'Category added.';
}

redirect(base_url('views/admin/category.php'));