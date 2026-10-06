<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();

require __DIR__ . '/../layout/header.php';
?>

<div class="page page-admin-index">
    <h1>Admin Actions</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <p class="success"><?= htmlspecialchars($_SESSION['success']) ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <ul class="admin-action-list">
        <li><a href="<?= base_url('views/admin/brand.php') ?>">Manage Brands</a> — add or edit brands</li>
        <li><a href="<?= base_url('views/admin/category.php') ?>">Manage Categories</a> — add or edit categories</li>
    </ul>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>