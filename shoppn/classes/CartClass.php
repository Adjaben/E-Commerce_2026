<?php
// classes/CartClass.php
// Model layer. Extends Database. All SQL for the `cart` table lives here.
//
// Not required until the cart task, but scaffolded now so the folder
// structure is stable and the header can safely show a cart count.

require_once __DIR__ . '/../core/db_class.php';

class CartClass extends Database
{
    public function getCartCount($customerId)
    {
        $stmt = $this->conn->prepare('SELECT COALESCE(SUM(qty), 0) AS total_qty FROM cart WHERE customer_id = ?');
        $stmt->bind_param('i', $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return (int) $row['total_qty'];
    }

    // TODO (next task): addToCart(), removeFromCart(), updateQty(), getCartItems(), getTotal().
}
