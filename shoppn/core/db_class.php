<?php
// core/db_class.php
// Task 2: the database connection base class.
// Every Model class (classes/*.php) extends this. It does nothing but connect —
// no SQL, no HTML, no business logic belongs here.

require_once __DIR__ . '/db_cred.php';

class Database
{
    protected $conn;

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            error_log('DB connection failed: ' . $this->conn->connect_error);
            die('Connection failed.');
        }

        $this->conn->set_charset('utf8mb4');
    }
}
