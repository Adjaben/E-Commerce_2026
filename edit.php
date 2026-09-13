<?php

require "db.php";

$id = intval($_GET["id"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $event_name = trim($_POST["event_name"]);
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $location = trim($_POST["location"]);

    $post_id = intval($_POST["id"]);

    $stmt = $conn->prepare(
        "UPDATE tasks
         SET event_name=?, event_date=?, event_time=?, location=?
         WHERE id=?"
    );

    $stmt->bind_param(
        "ssssi",
        $event_name,
        $event_date,
        $event_time,
        $location,
        $post_id
    );

    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare(
    "SELECT * FROM tasks WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$schedule = $stmt->get_result()->fetch_assoc();

$stmt->close();

if (!$schedule) {
    die("Schedule not found.");
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Schedule</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <h1>Edit Schedule</h1>

        <form method="POST" action="edit.php">

            <input
                type="hidden"
                name="id"
                value="<?php echo $schedule['id']; ?>"
            >

            <label>Event / Activity</label>

            <input
                type="text"
                name="event_name"
                value="<?php echo htmlspecialchars($schedule['event_name']); ?>"
                required
            >

            <label>Date</label>

            <input
                type="date"
                name="event_date"
                value="<?php echo $schedule['event_date']; ?>"
                required
            >

            <label>Time</label>

            <input
                type="time"
                name="event_time"
                value="<?php echo $schedule['event_time']; ?>"
                required
            >

            <label>Location</label>

            <input
                type="text"
                name="location"
                value="<?php echo htmlspecialchars($schedule['location']); ?>"
                required
            >

            <button type="submit">
                Update Schedule
            </button>

        </form>

        <a class="back" href="index.php">
            ← Back to Schedule
        </a>

    </div>

</body>

</html>