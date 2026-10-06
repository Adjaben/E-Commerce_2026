<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();

require_once __DIR__ . '/../../controllers/ProductController.php';
$controller = new ProductController();

$editBrand = null;
if (isset($_GET['edit_id'])) {
    $editId = filter_var($_GET['edit_id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($editId) {
        $editBrand = $controller->getBrandById($editId);
    }
}

$brands = $controller->getAllBrands();

require __DIR__ . '/../layout/header.php';
?>

<div class="page page-admin-brand">
    <h1><?= $editBrand ? 'Edit Brand' : 'Add Brand' ?></h1>

    <?php if (isset($_SESSION['success'])): ?>
        <p class="success"><?= htmlspecialchars($_SESSION['success']) ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($editBrand): ?>
        <form action="<?= base_url('actions/update_brand_action.php') ?>" method="POST">
            <input type="hidden" name="brand_id" value="<?= (int) $editBrand['brand_id'] ?>">
            <label>
                Brand Name
                <input type="text" name="brand_name" value="<?= htmlspecialchars($editBrand['brand_name']) ?>" required>
            </label>
            <button type="submit">Update Brand</button>
            <a href="<?= base_url('views/admin/brand.php') ?>">Cancel</a>
        </form>
    <?php else: ?>
        <form action="<?= base_url('actions/add_brand_action.php') ?>" method="POST">
            <label>
                Brand Name
                <input type="text" name="brand_name" required>
            </label>
            <button type="submit">Add Brand</button>
        </form>
    <?php endif; ?>

    <h2>Existing Brands</h2>
    <table>
        <thead><tr><th>Name</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($brands as $brand): ?>
            <tr>
                <td><?= htmlspecialchars($brand['brand_name']) ?></td>
                <td><a href="<?= base_url('views/admin/brand.php?edit_id=' . $brand['brand_id']) ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>