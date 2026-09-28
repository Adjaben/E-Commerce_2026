<?php
// classes/ProductClass.php
// Model layer. Extends Database. All SQL for products/brands/categories lives here.
//
// Tasks 1–4 only need enough here to populate the shared sidebar/header.
// Full product CRUD (add/update/delete, admin views) is intentionally left
// for the next lab task — this class is the home for it when you get there.

require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database
{
    public function getAllCategories()
    {
        $result = $this->conn->query('SELECT cat_id, cat_name FROM categories ORDER BY cat_name');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllBrands()
    {
        $result = $this->conn->query('SELECT brand_id, brand_name FROM brands ORDER BY brand_name');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // TODO (next task): getAllProducts(), getProductById(), addProduct(),
    // updateProduct(), deleteProduct(), searchProducts($keyword).
}
