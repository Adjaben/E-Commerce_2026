CREATE DATABASE IF NOT EXISTS shoppn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shoppn;

-- ----------------------------------------------------------------- customer
-- user_role: 1 = admin, 2 = customer (default)

CREATE TABLE IF NOT EXISTS customer (
    customer_id      INT AUTO_INCREMENT PRIMARY KEY,
    customer_name    VARCHAR(100)        NOT NULL,
    customer_email   VARCHAR(100)         NOT NULL UNIQUE,
    customer_pass    VARCHAR(255)        NOT NULL,
    customer_country VARCHAR(60)         DEFAULT NULL,
    customer_city    VARCHAR(60)         DEFAULT NULL,
    customer_contact VARCHAR(20)         DEFAULT NULL,
    customer_image   VARCHAR(255)        DEFAULT NULL,
    user_role        TINYINT(1)          NOT NULL DEFAULT 2,
    created_at       TIMESTAMP           DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- brands
CREATE TABLE IF NOT EXISTS brands (
    brand_id    INT AUTO_INCREMENT PRIMARY KEY,
    brand_name  VARCHAR(100) NOT NULL
) ENGINE=InnoDB;


-- categories

CREATE TABLE IF NOT EXISTS categories (
    cat_id    INT AUTO_INCREMENT PRIMARY KEY,
    cat_name  VARCHAR(100) NOT NULL
) ENGINE=InnoDB;


-- products
CREATE TABLE IF NOT EXISTS products (
    product_id       INT AUTO_INCREMENT PRIMARY KEY,
    product_cat      INT             DEFAULT NULL,
    product_brand    INT             DEFAULT NULL,
    product_title    VARCHAR(150)    NOT NULL,
    product_price    DECIMAL(10,2)   NOT NULL DEFAULT 0.00,
    product_desc     TEXT            DEFAULT NULL,
    product_image    VARCHAR(255)    DEFAULT NULL,
    product_keywords VARCHAR(255)    DEFAULT NULL,
    CONSTRAINT fk_product_cat   FOREIGN KEY (product_cat)   REFERENCES categories(cat_id)  ON DELETE SET NULL,
    CONSTRAINT fk_product_brand FOREIGN KEY (product_brand) REFERENCES brands(brand_id)    ON DELETE SET NULL
) ENGINE=InnoDB;


-- cart

CREATE TABLE IF NOT EXISTS cart (
    cart_id     INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT             NOT NULL,
    product_id  INT             NOT NULL,
    qty         INT             NOT NULL DEFAULT 1,
    added_at    TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_cart_customer FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE,
    CONSTRAINT fk_cart_product  FOREIGN KEY (product_id)  REFERENCES products(product_id)  ON DELETE CASCADE
) ENGINE=InnoDB;


-- orders

CREATE TABLE IF NOT EXISTS orders (
    order_id    INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT             NOT NULL,
    total       DECIMAL(10,2)   NOT NULL DEFAULT 0.00,
    status      VARCHAR(30)     NOT NULL DEFAULT 'pending',
    created_at  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_order_customer FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE
) ENGINE=InnoDB;



