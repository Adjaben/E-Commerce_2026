<?php

require_once __DIR__ . '/../../core/core.php';
require_login();

require __DIR__ . '/../layout/header.php';
?>

<div class="page page-account">
    <h1>My Account</h1>
    <p>Name: <?= htmlspecialchars($_SESSION['customer_name']) ?></p>
    <p>Email: <?= htmlspecialchars($_SESSION['customer_email']) ?></p>

</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
