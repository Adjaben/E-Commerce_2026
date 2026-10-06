<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/admin/category.php'));
}

$id   = filter_var($_POST['cat_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$name = trim(strip_tags($_POST['cat_name'] ?? ''));

if (!$id) {
    $_SESSION['error'] = 'Invalid category.';
    redirect(base_url('views/admin/category.php'));
}

if ($name === '' || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a valid category name.';
    redirect(base_url('views/admin/category.php?edit_id=' . $id));
}

$controller = new ProductController();
$success = $controller->updateCategory($id, $name);

$_SESSION[$success ? 'success' : 'error'] = $success ? 'Category updated.' : 'Could not update category.';

redirect(base_url('views/admin/category.php'));