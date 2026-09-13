<?php

require "db.php";

$result = $conn->query(
    "SELECT * FROM tasks ORDER BY event_date, event_time"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>My Schedule</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <h1>My Schedule</h1>

        <a class="add-button" href="create.php">
            + Add Schedule
        </a>

        <?php while ($row = $result->fetch_assoc()): ?>

            <div class="schedule">

                <h2>
                    <?php echo htmlspecialchars($row['event_name']); ?>
                </h2>

                <p>
                    <strong>Date:</strong>
                    <?php echo htmlspecialchars($row['event_date']); ?>
                </p>

                <p>
                    <strong>Time:</strong>
                    <?php echo htmlspecialchars($row['event_time']); ?>
                </p>

                <p>
                    <strong>Location:</strong>
                    <?php echo htmlspecialchars($row['location']); ?>
                </p>

                <div class="actions">

                    <a href="edit.php?id=<?php echo $row['id']; ?>">
                        Edit
                    </a>

                    <a class="delete"
                       href="delete.php?id=<?php echo $row['id']; ?>"
                       onclick="return confirm('Delete this schedule?');">
                        Delete
                    </a>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</body>

</html>

<?php $conn->close(); ?>