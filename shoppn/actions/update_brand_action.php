<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/admin/brand.php'));
}

$id   = filter_var($_POST['brand_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$name = trim(strip_tags($_POST['brand_name'] ?? ''));

if (!$id) {
    $_SESSION['error'] = 'Invalid brand.';
    redirect(base_url('views/admin/brand.php'));
}

if ($name === '' || strlen($name) > 100) {
    $_SESSION['error'] = 'Please enter a valid brand name.';
    redirect(base_url('views/admin/brand.php?edit_id=' . $id));
}

$controller = new ProductController();
$success = $controller->updateBrand($id, $name);

$_SESSION[$success ? 'success' : 'error'] = $success ? 'Brand updated.' : 'Could not update brand.';

redirect(base_url('views/admin/brand.php'));