<?php
require_once __DIR__ . "/config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: admin.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: admin.php?error=" . urlencode("Invalid employee record."));
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM employees WHERE id = :id");
    $stmt->execute([":id" => $id]);

    header("Location: admin.php?deleted=1");
    exit;

} catch (PDOException $e) {
    header("Location: admin.php?error=" . urlencode("Unable to delete the employee record."));
    exit;
}