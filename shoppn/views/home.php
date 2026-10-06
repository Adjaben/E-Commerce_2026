<?php
require __DIR__ . '/layout/header.php';
?>

<div class="page page-home">
    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h1>Welcome to Shoppn</h1>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
