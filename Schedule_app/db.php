<?php

// Load database credentials from .env
$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    die("Database configuration file not found.");
}

$env = parse_ini_file($envFile);

$host = $env['DB_HOST'];
$db_user = $env['DB_USER'];
$db_pass = $env['DB_PASS'];
$db_name = $env['DB_NAME'];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}

// Create the appointments table if it does not already exist.
$pdo->exec("
    CREATE TABLE IF NOT EXISTS appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        appt_date DATE NOT NULL,
        appt_time TIME NOT NULL,
        location VARCHAR(255)
    )
");