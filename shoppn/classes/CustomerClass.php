<?php


require_once __DIR__ . '/../core/db_class.php';

class CustomerClass extends Database
{
    
    public function emailExists($email)
{
    $stmt = $this->conn->prepare(
        'SELECT customer_email FROM customer WHERE customer_email = ?'
    );

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $stmt->store_result();

    $exists = $stmt->num_rows > 0;

    $stmt->close();

    return $exists;
}

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

   
    public function getCustomerByEmail($email)
{
    $stmt = $this->conn->prepare(
        'SELECT customer_id,
                customer_name,
                customer_email,
                customer_pass,
                customer_country,
                customer_city,
                customer_contact,
                customer_image,
                user_role
         FROM customer
         WHERE customer_email = ?'
    );

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $stmt->bind_result(
        $customer_id,
        $customer_name,
        $customer_email,
        $customer_pass,
        $customer_country,
        $customer_city,
        $customer_contact,
        $customer_image,
        $user_role
    );

    if (!$stmt->fetch()) {
        $stmt->close();
        return false;
    }

    $row = [
        'customer_id'      => $customer_id,
        'customer_name'    => $customer_name,
        'customer_email'   => $customer_email,
        'customer_pass'    => $customer_pass,
        'customer_country' => $customer_country,
        'customer_city'    => $customer_city,
        'customer_contact' => $customer_contact,
        'customer_image'   => $customer_image,
        'user_role'        => $user_role
    ];

    $stmt->close();

    return $row;
}

   
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

   
    public function getCustomerById($id)
{
    $stmt = $this->conn->prepare(
        'SELECT customer_id,
                customer_name,
                customer_email,
                customer_pass,
                customer_country,
                customer_city,
                customer_contact,
                customer_image,
                user_role
         FROM customer
         WHERE customer_id = ?'
    );

    $stmt->bind_param('i', $id);
    $stmt->execute();

    $stmt->bind_result(
        $customer_id,
        $customer_name,
        $customer_email,
        $customer_pass,
        $customer_country,
        $customer_city,
        $customer_contact,
        $customer_image,
        $user_role
    );

    if (!$stmt->fetch()) {
        $stmt->close();
        return false;
    }

    $row = [
        'customer_id'      => $customer_id,
        'customer_name'    => $customer_name,
        'customer_email'   => $customer_email,
        'customer_pass'    => $customer_pass,
        'customer_country' => $customer_country,
        'customer_city'    => $customer_city,
        'customer_contact' => $customer_contact,
        'customer_image'   => $customer_image,
        'user_role'        => $user_role
    ];

    $stmt->close();

    return $row;
}
}
