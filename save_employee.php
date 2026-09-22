<?php
require_once __DIR__ . "/config/database.php";

function redirectWithError(string $message): never {
    header("Location: index.php?error=" . urlencode($message));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$employeeId  = strtoupper(trim($_POST["employee_id"] ?? ""));
$fullName    = trim($_POST["full_name"] ?? "");
$email       = strtolower(trim($_POST["email"] ?? ""));
$phone       = preg_replace("/\D/", "", $_POST["phone"] ?? "");
$department  = trim($_POST["department"] ?? "");
$designation = trim($_POST["designation"] ?? "");
$joiningDate = trim($_POST["joining_date"] ?? "");

$departments = [
    "Engineering", "Human Resources", "Finance", "Marketing",
    "Sales", "Operations", "Design"
];

if (!preg_match("/^[A-Z0-9-]{3,20}$/", $employeeId)) {
    redirectWithError("Employee ID must contain 3–20 letters, numbers or hyphens.");
}

if ($fullName === "" || mb_strlen($fullName) < 2 || mb_strlen($fullName) > 100) {
    redirectWithError("Please enter a valid full name.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
    redirectWithError("Please enter a valid email address.");
}

if (!preg_match("/^[6-9][0-9]{9}$/", $phone)) {
    redirectWithError("Please enter a valid 10-digit Indian mobile number starting with 6–9.");
}

if (!in_array($department, $departments, true)) {
    redirectWithError("Please select a valid department.");
}

if ($designation === "" || mb_strlen($designation) > 100) {
    redirectWithError("Please enter a valid designation.");
}

$date = DateTime::createFromFormat("Y-m-d", $joiningDate);
if (!$date || $date->format("Y-m-d") !== $joiningDate) {
    redirectWithError("Please enter a valid joining date.");
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO employees
        (employee_id, full_name, email, phone, department, designation, joining_date)
        VALUES (:employee_id, :full_name, :email, :phone, :department, :designation, :joining_date)"
    );

    $stmt->execute([
        ":employee_id" => $employeeId,
        ":full_name" => $fullName,
        ":email" => $email,
        ":phone" => $phone,
        ":department" => $department,
        ":designation" => $designation,
        ":joining_date" => $joiningDate
    ]);

    header("Location: index.php?success=1");
    exit;

} catch (PDOException $e) {
    if ($e->getCode() === "23000") {
        redirectWithError("Employee ID, email or phone number already exists.");
    }
    redirectWithError("Unable to save the employee record. Please try again.");
}
