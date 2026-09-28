<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM appointments ORDER BY appt_date ASC, appt_time ASC");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);


$flash = $_GET['flash'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="topbar">
        <div class="wrap topbar-inner">
            <h1>Scheduling</h1>
            <a class="btn btn-primary" href="create.php">+ New appointment</a>
        </div>
    </header>

    <main class="wrap">

        <?php if ($flash === 'created'): ?>
            <p class="notice">Appointment added.</p>
        <?php elseif ($flash === 'updated'): ?>
            <p class="notice">Appointment updated.</p>
        <?php elseif ($flash === 'deleted'): ?>
            <p class="notice">Appointment deleted.</p>
        <?php endif; ?>

        <?php if (count($appointments) === 0): ?>

            <div class="empty">
                <p>Nothing on the schedule yet.</p>
                <a class="btn btn-primary" href="create.php">Add the first appointment</a>
            </div>

        <?php else: ?>

            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars(date('D, M j Y', strtotime($row['appt_date']))) ?></td>
                            <td><?= htmlspecialchars(date('g:i A', strtotime($row['appt_time']))) ?></td>
                            <td>
                                <span class="title-cell"><?= htmlspecialchars($row['title']) ?></span>
                                <?php if (!empty($row['description'])): ?>
                                    <span class="desc-cell"><?= htmlspecialchars($row['description']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['location'] ?: '—') ?></td>
                            <td class="actions-col">
                                <a class="link-edit" href="edit.php?id=<?= (int)$row['id'] ?>">Edit</a>
                                <a class="link-delete"
                                   href="delete.php?id=<?= (int)$row['id'] ?>"
                                   onclick="return confirm('Delete this appointment?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

    </main>

</body>
</html>
