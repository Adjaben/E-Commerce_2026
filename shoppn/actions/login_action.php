<?php


require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/login.php'));
}

$email = trim(strip_tags($_POST['email'] ?? ''));
$pass  = $_POST['pass'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $pass === '') {
    $_SESSION['error'] = 'Please enter a valid email and password.';
    redirect(base_url('views/login.php'));
}

$controller = new CustomerController();
$result = $controller->login($email, $pass);

if ($result['success']) {
    $_SESSION['customer_id']    = $result['customer_id'];
    $_SESSION['customer_name']  = $result['name'];
    $_SESSION['customer_email'] = $result['email'];
    $_SESSION['user_role']      = $result['user_role'];

    redirect(base_url('index.php'));
} else {
    $_SESSION['error'] = $result['error'];
    redirect(base_url('views/login.php'));
}
