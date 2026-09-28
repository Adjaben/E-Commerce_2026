<?php
// views/login.php
// View layer. Plain HTML form — no database calls here.
require_once __DIR__ . '/../core/core.php';
require __DIR__ . '/layout/header.php';
?>

<div class="page page-login">
    <h1>Login</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form id="login-form" action="<?= base_url('actions/login_action.php') ?>" method="POST" novalidate>
        <label>
            Email
            <input type="email" name="email" id="email" required>
        </label>

        <label>
            Password
            <input type="password" name="pass" id="pass" required>
        </label>

        <div class="form-errors"></div>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="<?= base_url('views/register.php') ?>">Register</a></p>
</div>

<script src="<?= base_url('js/validate.js') ?>"></script>

<?php require __DIR__ . '/layout/footer.php'; ?>
