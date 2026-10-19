<?php

require_once __DIR__ . '/../core/db_class.php';

class CartClass extends Database
{
    public function isInCart($product_id, $ip)
    {
        $stmt = $this->conn->prepare('SELECT p_id FROM cart WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('is', $product_id, $ip);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        $stmt = $this->conn->prepare('INSERT INTO cart (p_id, ip_add, c_id, qty) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('isii', $product_id, $ip, $customer_id, $qty);

        if (!$stmt->execute()) {
            error_log('addToCart failed: ' . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }

    public function getCartItems($ip)
    {
        $stmt = $this->conn->prepare(
            'SELECT cart.*, products.product_title, products.product_price, products.product_image
             FROM cart
             JOIN products ON cart.p_id = products.product_id
             WHERE cart.ip_add = ?'
        );
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $rows ?: [];
    }

    public function getCartCount($ip)
    {
        $stmt = $this->conn->prepare('SELECT COUNT(*) FROM cart WHERE ip_add = ?');
        $stmt->bind_param('s', $ip);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return (int) $count;
    }

    public function getCartTotal($ip)
    {
        $total = 0.0;

        foreach ($this->getCartItems($ip) as $item) {
            $total += $item['qty'] * $item['product_price'];
        }

        return $total;
    }

    // ---------- Task 12 ----------

    public function removeFromCart($product_id, $ip)
    {
        $stmt = $this->conn->prepare('DELETE FROM cart WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('is', $product_id, $ip);
        $success = $stmt->execute();

        if (!$success) {
            error_log('removeFromCart failed: ' . $stmt->error);
        }

        $stmt->close();
        return $success;
    }

    public function updateQty($product_id, $new_qty, $ip)
    {
        if ($new_qty < 1) {
            return false;
        }

        $stmt = $this->conn->prepare('UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?');
        $stmt->bind_param('iis', $new_qty, $product_id, $ip);
        $success = $stmt->execute();

        if (!$success) {
            error_log('updateQty failed: ' . $stmt->error);
        }

        $stmt->close();
        return $success;
    }
}