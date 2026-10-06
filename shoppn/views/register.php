<?php
// views/register.php
// View layer. Plain HTML form — no database calls here.
require_once __DIR__ . '/../core/core.php';
require __DIR__ . '/layout/header.php';
?>

<div class="page page-register">
    <h1>Create an account</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form id="register-form" action="<?= base_url('actions/register_action.php') ?>" method="POST" novalidate>
        <label>
            Full Name
            <input type="text" name="name" id="name" required>
        </label>

        <label>
            Email
            <input type="email" name="email" id="email" required>
        </label>

        <label>
        <span>Password
    <input type="password" name="pass" id="pass" required
           pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$"
           title="Min 8 characters, with an uppercase letter, a lowercase letter, a number, and a symbol.">
    <small style="color: var(--text-muted); font-size: 0.8rem;">
        At least 8 characters, with an uppercase letter, a lowercase letter, a number, and a symbol.
    </small>
</label>

        <label>
            Country
            <select name="country" id="country">
                <option value="Ghana">Ghana</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Kenya">Kenya</option>
                <option value="Other">Other</option>
            </select>
        </label>

        <label>
            City
            <input type="text" name="city" id="city">
        </label>

        <label>
            Contact Number
            <input type="text" name="contact" id="contact">
        </label>

        <div class="form-errors"></div>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="<?= base_url('views/login.php') ?>">Login</a></p>
</div>

<script src="<?= base_url('js/validate.js') ?>"></script>

<?php require __DIR__ . '/layout/footer.php'; ?>
