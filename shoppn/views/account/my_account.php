<?php
// views/account/my_account.php
// View layer. Protected page — require_login() at the very top, before
// any HTML is output, per the MVC note in the lab brief.
require_once __DIR__ . '/../../core/core.php';
require_login();

require __DIR__ . '/../layout/header.php';
?>

<div class="page page-account">
    <h1>My Account</h1>
    <p>Name: <?= htmlspecialchars($_SESSION['customer_name']) ?></p>
    <p>Email: <?= htmlspecialchars($_SESSION['customer_email']) ?></p>
    <p><em>Edit account, change password, and order history are built out in a later task.</em></p>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
