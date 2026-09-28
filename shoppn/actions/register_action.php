<?php
// actions/register_action.php
// Task 3. Thin file: only runs on POST, sanitises input, calls the
// Controller, and redirects. No HTML is ever echoed from here.

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(base_url('views/register.php'));
}

// ---- sanitise ----------------------------------------------------
$name    = trim(strip_tags($_POST['name'] ?? ''));
$email   = trim(strip_tags($_POST['email'] ?? ''));
$pass    = $_POST['pass'] ?? '';
$country = trim(strip_tags($_POST['country'] ?? ''));
$city    = trim(strip_tags($_POST['city'] ?? ''));
$contact = trim(strip_tags($_POST['contact'] ?? ''));

// ---- validate ------------------------------------------------------
$errors = [];

if ($name === '' || strlen($name) > 100) {
    $errors[] = 'Please enter a valid name.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 50) {
    $errors[] = 'Please enter a valid email address.';
}

if (strlen($pass) < 6) {
    $errors[] = 'Password must be at least 6 characters.';
}

if (strlen($country) > 60 || strlen($city) > 60 || strlen($contact) > 20) {
    $errors[] = 'One of the fields is too long.';
}

if (!empty($errors)) {
    $_SESSION['error'] = implode(' ', $errors);
    redirect(base_url('views/register.php'));
}

// ---- call the controller -------------------------------------------
$controller = new CustomerController();
$result = $controller->register([
    'name'    => $name,
    'email'   => $email,
    'pass'    => $pass,
    'country' => $country,
    'city'    => $city,
    'contact' => $contact,
]);

if ($result['success']) {
    $_SESSION['customer_id'] = $result['customer_id'];
    $_SESSION['customer_name'] = $result['name'];
    $_SESSION['customer_email'] = $email;
    $_SESSION['user_role'] = $result['user_role'];

    redirect(base_url('views/account/my_account.php'));
} else {
    $_SESSION['error'] = $result['error'];
    redirect(base_url('views/register.php'));
}
