<?php
// create.php — CREATE: form for a new appointment, and the insert handler.
require 'db.php';

$errors = [];
$title = $description = $appt_date = $appt_time = $location = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $appt_date   = trim($_POST['appt_date'] ?? '');
    $appt_time   = trim($_POST['appt_time'] ?? '');
    $location    = trim($_POST['location'] ?? '');

    if ($title === '')     $errors[] = 'Title is required.';
    if ($appt_date === '') $errors[] = 'Date is required.';
    if ($appt_time === '') $errors[] = 'Time is required.';

    if (empty($errors)) {
        $stmt = $pdo->prepare(
            "INSERT INTO appointments (title, description, appt_date, appt_time, location)
             VALUES (:title, :description, :appt_date, :appt_time, :location)"
        );
        $stmt->execute([
            ':title'       => $title,
            ':description' => $description,
            ':appt_date'   => $appt_date,
            ':appt_time'   => $appt_time,
            ':location'    => $location,
        ]);

        header('Location: index.php?flash=created');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New appointment — Schedule</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="topbar">
        <div class="wrap topbar-inner">
            <h1>Schedule</h1>
            <a class="btn btn-ghost" href="index.php">Back to list</a>
        </div>
    </header>

    <main class="wrap wrap-narrow">

        <h2>New appointment</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="create.php" class="form-card">

            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($description) ?></textarea>

            <div class="field-row">
                <div class="field-col">
                    <label for="appt_date">Date</label>
                    <input type="date" id="appt_date" name="appt_date" value="<?= htmlspecialchars($appt_date) ?>" required>
                </div>
                <div class="field-col">
                    <label for="appt_time">Time</label>
                    <input type="time" id="appt_time" name="appt_time" value="<?= htmlspecialchars($appt_time) ?>" required>
                </div>
            </div>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" value="<?= htmlspecialchars($location) ?>">

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save appointment</button>
                <a class="btn btn-ghost" href="index.php">Cancel</a>
            </div>

        </form>

    </main>

</body>
</html>
