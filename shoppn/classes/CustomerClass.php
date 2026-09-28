<?php
// classes/CustomerClass.php
// Model layer. Extends Database. All SQL for the `customer` table lives here.
// No HTML, no $_POST, no echo — ever.

require_once __DIR__ . '/../core/db_class.php';

class CustomerClass extends Database
{
    /**
     * Task 3: check whether an email is already registered.
     */
    public function emailExists($email)
    {
        $stmt = $this->conn->prepare('SELECT customer_email FROM customer WHERE customer_email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();

        return $exists;
    }

    /**
     * Task 3: insert a new customer. Expects an already-hashed password.
     * Returns the new customer_id on success, false on failure.
     */
    public function addCustomer($name, $email, $hashedPass, $country, $city, $contact)
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO customer (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, user_role)
             VALUES (?, ?, ?, ?, ?, ?, 2)'
        );
        $stmt->bind_param('ssssss', $name, $email, $hashedPass, $country, $city, $contact);

        if (!$stmt->execute()) {
            error_log('addCustomer failed: ' . $stmt->error);
            $stmt->close();
            return false;
        }

        $newId = $stmt->insert_id;
        $stmt->close();

        return $newId;
    }

    /**
     * Task 4: fetch a single customer row by email, or false if none.
     */
    public function getCustomerByEmail($email)
    {
        $stmt = $this->conn->prepare('SELECT * FROM customer WHERE customer_email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ?: false;
    }

    /**
     * Task 4: verify credentials. Returns the customer row on success, false on failure.
     */
    public function login($email, $pass)
    {
        $row = $this->getCustomerByEmail($email);

        if (!$row) {
            return false;
        }

        if (!password_verify($pass, $row['customer_pass'])) {
            return false;
        }

        return $row;
    }

    /**
     * Fetch a customer by id — used by my_account.php etc.
     */
    public function getCustomerById($id)
    {
        $stmt = $this->conn->prepare('SELECT * FROM customer WHERE customer_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ?: false;
    }
}
