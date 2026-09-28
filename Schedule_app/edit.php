<?php
// edit.php — UPDATE: loads one appointment, shows a pre-filled form, saves changes.
require 'db.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = :id");
$stmt->execute([':id' => $id]);
$appointment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$appointment) {
    header('Location: index.php');
    exit;
}

$errors = [];
$title       = $appointment['title'];
$description = $appointment['description'];
$appt_date   = $appointment['appt_date'];
$appt_time   = $appointment['appt_time'];
$location    = $appointment['location'];

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
        $update = $pdo->prepare(
            "UPDATE appointments
             SET title = :title, description = :description,
                 appt_date = :appt_date, appt_time = :appt_time, location = :location
             WHERE id = :id"
        );
        $update->execute([
            ':title'       => $title,
            ':description' => $description,
            ':appt_date'   => $appt_date,
            ':appt_time'   => $appt_time,
            ':location'    => $location,
            ':id'          => $id,
        ]);

        header('Location: index.php?flash=updated');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit appointment — Schedule</title>
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

        <h2>Edit appointment</h2>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="edit.php?id=<?= (int)$id ?>" class="form-card">
            <input type="hidden" name="id" value="<?= (int)$id ?>">

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
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a class="btn btn-ghost" href="index.php">Cancel</a>
            </div>

        </form>

    </main>

</body>
</html>
