<?php
// controllers/CartController.php
// Controller layer. Instantiates CartClass. Full add/remove/update methods
// arrive in the cart task — this exists now only so header.php can safely
// display a cart count for logged-in customers.

require_once __DIR__ . '/../classes/CartClass.php';

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartClass();
    }

    public function getCartCount($customerId)
    {
        return $this->cartModel->getCartCount($customerId);
    }
}
