<?php

$host = "localhost";
$db_user = "root";
$db_pass = "";

$conn = new mysqli($host, $db_user, $db_pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->select_db("tasks_app");

$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "<h2>Setup complete!</h2>";
    echo "<p><a href='index.php'>Go to My Schedule</a></p>";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>