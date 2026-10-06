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
    
    public function addBrand($name)
{
    return $this->productModel->addBrand($name);
}

public function getAllBrands()
{
    return $this->productModel->getAllBrands();
}

public function getBrandById($id)
{
    return $this->productModel->getBrandById($id);
}

public function updateBrand($id, $name)
{
    return $this->productModel->updateBrand($id, $name);
}

public function addCategory($name)
{
    return $this->productModel->addCategory($name);
}

public function getAllCategories()
{
    return $this->productModel->getAllCategories();
}

public function getCategoryById($id)
{
    return $this->productModel->getCategoryById($id);
}

public function updateCategory($id, $name)
{
    return $this->productModel->updateCategory($id, $name);
}
}
