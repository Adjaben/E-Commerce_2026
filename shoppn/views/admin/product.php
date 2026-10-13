<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();

require_once __DIR__ . '/../../controllers/ProductController.php';
$controller = new ProductController();

$editProduct = null;
if (isset($_GET['edit_id'])) {
    $editId = filter_var($_GET['edit_id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($editId) {
        $editProduct = $controller->getProductById($editId);
    }
}

$categories = $controller->getAllCategories();
$brands     = $controller->getAllBrands();
$products   = $controller->getAllProducts();

require __DIR__ . '/../layout/header.php';
?>

<div class="page page-admin-product">
    <h1><?= $editProduct ? 'Edit Product' : 'Add Product' ?></h1>

    <?php if (isset($_SESSION['success'])): ?>
        <p class="success"><?= htmlspecialchars($_SESSION['success']) ?></p>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= htmlspecialchars($_SESSION['error']) ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form id="product-form"
          action="<?= base_url($editProduct ? 'actions/update_product_action.php' : 'actions/add_product_action.php') ?>"
          method="POST" enctype="multipart/form-data">

        <?php if ($editProduct): ?>
            <input type="hidden" name="product_id" value="<?= (int) $editProduct['product_id'] ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editProduct['product_image'] ?? '') ?>">
        <?php endif; ?>

        <label>
            Product Title
            <input type="text" name="product_title" maxlength="150" required
                   value="<?= htmlspecialchars($editProduct['product_title'] ?? '') ?>">
        </label>

        <label>
            Price
            <input type="number" name="product_price" step="0.01" min="0" required
                   value="<?= htmlspecialchars($editProduct['product_price'] ?? '') ?>">
        </label>

        <label>
            Category
            <select name="product_cat" required>
                <option value="">Select a category</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= (int) $c['cat_id'] ?>"
                        <?= ($editProduct && (int) $editProduct['product_cat'] === (int) $c['cat_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['cat_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Brand
            <select name="product_brand" required>
                <option value="">Select a brand</option>
                <?php foreach ($brands as $b): ?>
                    <option value="<?= (int) $b['brand_id'] ?>"
                        <?= ($editProduct && (int) $editProduct['product_brand'] === (int) $b['brand_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b['brand_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Description
            <textarea name="product_desc" rows="4"><?= htmlspecialchars($editProduct['product_desc'] ?? '') ?></textarea>
        </label>

        <label>
            Keywords
            <input type="text" name="product_keywords" maxlength="255"
                   value="<?= htmlspecialchars($editProduct['product_keywords'] ?? '') ?>">
        </label>

        <?php if ($editProduct && !empty($editProduct['product_image'])): ?>
            <p>Current image:</p>
            <img class="image-preview" src="<?= base_url('images/products/' . rawurlencode($editProduct['product_image'])) ?>" alt="Current product image">
        <?php endif; ?>

        <label>
            Product Image <?= $editProduct ? '(leave empty to keep the current one)' : '' ?>
            <input type="file" name="product_image" id="product_image"
                   accept="image/jpeg,image/png,image/gif,image/webp" <?= $editProduct ? '' : 'required' ?>>
        </label>

        <button type="submit"><?= $editProduct ? 'Update Product' : 'Add Product' ?></button>
        <?php if ($editProduct): ?>
            <a href="<?= base_url('views/admin/product.php') ?>">Cancel</a>
        <?php endif; ?>
    </form>

    <h2>Existing Products</h2>
    <table>
        <thead><tr><th>Title</th><th>Category</th><th>Brand</th><th>Price</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['product_title']) ?></td>
                <td><?= htmlspecialchars($p['cat_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($p['brand_name'] ?? '') ?></td>
                <td><?= number_format($p['product_price'], 2) ?></td>
                <td><a href="<?= base_url('views/admin/product.php?edit_id=' . (int) $p['product_id']) ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="<?= base_url('js/validate.js') ?>"></script>

<?php require __DIR__ . '/../layout/footer.php'; ?>