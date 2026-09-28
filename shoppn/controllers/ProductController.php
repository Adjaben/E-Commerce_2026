<?php
// controllers/ProductController.php
// Controller layer. Instantiates ProductClass and exposes what the views
// need right now (the sidebar). Product CRUD methods get added here in
// the next lab task.

require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductClass();
    }

    public function getSidebarCategories()
    {
        return $this->productModel->getAllCategories();
    }

    public function getSidebarBrands()
    {
        return $this->productModel->getAllBrands();
    }
}
