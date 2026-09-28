<?php
// controllers/CustomerController.php
// Controller layer. Receives already-sanitised data from an action file,
// calls the Model, and returns a structured result array. No HTML here.

require_once __DIR__ . '/../classes/CustomerClass.php';

class CustomerController
{
    private $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerClass();
    }

    /**
     * Task 3: register a new customer.
     * $data expects: name, email, pass, country, city, contact
     */
    public function register($data)
    {
        if ($this->customerModel->emailExists($data['email'])) {
            return ['success' => false, 'error' => 'Email already registered'];
        }

        $hashed = password_hash($data['pass'], PASSWORD_BCRYPT);

        $newId = $this->customerModel->addCustomer(
            $data['name'],
            $data['email'],
            $hashed,
            $data['country'],
            $data['city'],
            $data['contact']
        );

        if ($newId === false) {
            return ['success' => false, 'error' => 'Could not create account. Please try again.'];
        }

        return [
            'success'     => true,
            'customer_id' => $newId,
            'user_role'   => 2,
            'name'        => $data['name'],
        ];
    }

    /**
     * Task 4: log a customer in.
     */
    public function login($email, $pass)
    {
        $row = $this->customerModel->login($email, $pass);

        if (!$row) {
            return ['success' => false, 'error' => 'Incorrect email or password'];
        }

        return [
            'success'     => true,
            'customer_id' => $row['customer_id'],
            'name'        => $row['customer_name'],
            'email'       => $row['customer_email'],
            'user_role'   => (int) $row['user_role'],
        ];
    }

    public function getCustomerById($id)
    {
        return $this->customerModel->getCustomerById($id);
    }
}
