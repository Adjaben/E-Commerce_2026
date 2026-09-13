<<?php

require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $event_name = trim($_POST["event_name"]);
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $location = trim($_POST["location"]);

    $stmt = $conn->prepare(
        "INSERT INTO schedules (event_name, event_date, event_time, location)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssss",
        $event_name,
        $event_date,
        $event_time,
        $location
    );

    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Schedule</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h2>Add Schedule</h2>

    <form method="POST" action="create.php">

        <label>Event / Activity</label><br>
        <input type="text" name="event_name" required>

        <br><br>

        <label>Date</label><br>
        <input type="date" name="event_date" required>

        <br><br>

        <label>Time</label><br>
        <input type="time" name="event_time" required>

        <br><br>

        <label>Location</label><br>
        <input type="text" name="location" required>

        <br><br>

        <button type="submit">Save Schedule</button>

    </form>

    <br>

    <a href="index.php">Back to Schedule</a>

</body>

</html>
