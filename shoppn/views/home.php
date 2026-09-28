<?php
// views/home.php
// View layer. No database calls — just includes the shared layout.
require __DIR__ . '/layout/header.php';
?>

<div class="page page-home">
    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h1>Welcome to Shoppn</h1>
    <p>This is the home page. Once Task 5 (products) is built, featured products will render here.</p>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
