<?php


require_once __DIR__ . '/../core/db_class.php';

class ProductClass extends Database
{
   
    public function getAllCategories()
    {
        $result = $this->conn->query('SELECT cat_id, cat_name FROM categories ORDER BY cat_name');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

        
        public function addCategory($name)
        {
            $stmt = $this->conn->prepare('INSERT INTO categories (cat_name) VALUES (?)');
            $stmt->bind_param('s', $name);
    
            if (!$stmt->execute()) {
                error_log('addCategory failed: ' . $stmt->error);
                $stmt->close();
                return false;
            }
    
            $newId = $stmt->insert_id;
            $stmt->close();
    
            return $newId;
        }
    

        public function getCategoryById($id)
        {
            $stmt = $this->conn->prepare('SELECT * FROM categories WHERE cat_id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
    
            return $row ?: false;
        }
    
        
        public function updateCategory($id, $name)
        {
            $stmt = $this->conn->prepare('UPDATE categories SET cat_name = ? WHERE cat_id = ?');
            $stmt->bind_param('si', $name, $id);
            $success = $stmt->execute();
    
            if (!$success) {
                error_log('updateCategory failed: ' . $stmt->error);
            }
    
            $stmt->close();
    
            return $success;
        }


   
    public function addBrand($name)
    {
        $stmt = $this->conn->prepare('INSERT INTO brands (brand_name) VALUES (?)');
        $stmt->bind_param('s', $name);

        if (!$stmt->execute()) {
            error_log('addBrand failed: ' . $stmt->error);
            $stmt->close();
            return false;
        }

        $newId = $stmt->insert_id;
        $stmt->close();

        return $newId;
    }

    
    public function getAllBrands()
    {
        $result = $this->conn->query('SELECT * FROM brands ORDER BY brand_name ASC');
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

   
    public function getBrandById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM brands WHERE brand_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ?: false;
    }

    
    public function updateBrand($id, $name)
    {
        $stmt = $this->conn->prepare('UPDATE brands SET brand_name = ? WHERE brand_id = ?');
        $stmt->bind_param('si', $name, $id);
        $success = $stmt->execute();

        if (!$success) {
            error_log('updateBrand failed: ' . $stmt->error);
        }

        $stmt->close();

        return $success;
    }

        public function addProduct($cat, $brand, $title, $price, $desc, $image, $keywords)
        {
            $stmt = $this->conn->prepare(
                'INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->bind_param('iisdsss', $cat, $brand, $title, $price, $desc, $image, $keywords);
    
            if (!$stmt->execute()) {
                error_log('addProduct failed: ' . $stmt->error);
                $stmt->close();
                return false;
            }
    
            $newId = $stmt->insert_id;
            $stmt->close();
    
            return $newId;
        }
    
        public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywords)
        {
            $stmt = $this->conn->prepare(
                'UPDATE products
                 SET product_cat = ?, product_brand = ?, product_title = ?, product_price = ?,
                     product_desc = ?, product_image = ?, product_keywords = ?
                 WHERE product_id = ?'
            );
            $stmt->bind_param('iisdsssi', $cat, $brand, $title, $price, $desc, $image, $keywords, $id);
            $success = $stmt->execute();
    
            if (!$success) {
                error_log('updateProduct failed: ' . $stmt->error);
            }
    
            $stmt->close();
    
            return $success;
        }
    
        // One product plus its category and brand names
        public function getProductById($id)
        {
            $stmt = $this->conn->prepare(
                'SELECT p.*, c.cat_name, b.brand_name
                 FROM products p
                 LEFT JOIN categories c ON p.product_cat = c.cat_id
                 LEFT JOIN brands b ON p.product_brand = b.brand_id
                 WHERE p.product_id = ?'
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
    
            return $row ?: false;
        }
    
        // For the admin table (so each product gets an Edit link)
        public function getAllProducts()
        {
            $result = $this->conn->query(
                'SELECT p.*, c.cat_name, b.brand_name
                 FROM products p
                 LEFT JOIN categories c ON p.product_cat = c.cat_id
                 LEFT JOIN brands b ON p.product_brand = b.brand_id
                 ORDER BY p.product_id DESC'
            );
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }
    
        // ---------- Task 10: product display ----------
    
        private function fetchRows($stmt)
        {
            $stmt->execute();
            $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
    
            return $rows ?: [];
        }
    
        public function getFeaturedProducts($limit = 6)
        {
            $stmt = $this->conn->prepare('SELECT * FROM products ORDER BY RAND() LIMIT ?');
            $stmt->bind_param('i', $limit);
            return $this->fetchRows($stmt);
        }
    
        public function getProductsByCategory($cat_id)
        {
            $stmt = $this->conn->prepare('SELECT * FROM products WHERE product_cat = ?');
            $stmt->bind_param('i', $cat_id);
            return $this->fetchRows($stmt);
        }
    
        public function getProductsByBrand($brand_id)
        {
            $stmt = $this->conn->prepare('SELECT * FROM products WHERE product_brand = ?');
            $stmt->bind_param('i', $brand_id);
            return $this->fetchRows($stmt);
        }
    
        public function searchProducts($query)
        {
            $like = '%' . $query . '%';
            $stmt = $this->conn->prepare('SELECT * FROM products WHERE product_title LIKE ? OR product_keywords LIKE ?');
            $stmt->bind_param('ss', $like, $like);
            return $this->fetchRows($stmt);
        }


        
}