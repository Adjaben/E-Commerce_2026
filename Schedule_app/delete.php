<?php
// delete.php — DELETE: removes one appointment, then redirects back to the list.
require 'db.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header('Location: index.php?flash=deleted');
    exit;
}

header('Location: index.php');
exit;
