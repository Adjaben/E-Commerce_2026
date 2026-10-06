<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();

require_once __DIR__ . '/../../controllers/ProductController.php';
$controller = new ProductController();

$editCategory = null;
if (isset($_GET['edit_id'])) {
    $editId = filter_var($_GET['edit_id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($editId) {
        $editCategory = $controller->getCategoryById($editId);
    }
}

$categories = $controller->getAllCategories();

require __DIR__ . '/../layout/header.php';
?>

<div class="page page-admin-category">
    <h1><?= $editCategory ? 'Edit Category' : 'Add Category' ?></h1>

    <?php if (isset($_SESSION['success'])): ?>
        <p class="success"><?= htmlspecialchars($_SESSION['success']) ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($editCategory): ?>
        <form action="<?= base_url('actions/update_category_action.php') ?>" method="POST">
            <input type="hidden" name="cat_id" value="<?= (int) $editCategory['cat_id'] ?>">
            <label>
                Category Name
                <input type="text" name="cat_name" value="<?= htmlspecialchars($editCategory['cat_name']) ?>" required>
            </label>
            <button type="submit">Update Category</button>
            <a href="<?= base_url('views/admin/category.php') ?>">Cancel</a>
        </form>
    <?php else: ?>
        <form action="<?= base_url('actions/add_category_action.php') ?>" method="POST">
            <label>
                Category Name
                <input type="text" name="cat_name" required>
            </label>
            <button type="submit">Add Category</button>
        </form>
    <?php endif; ?>

    <h2>Existing Categories</h2>
    <table>
        <thead><tr><th>Name</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= htmlspecialchars($category['cat_name']) ?></td>
                <td><a href="<?= base_url('views/admin/category.php?edit_id=' . $category['cat_id']) ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>