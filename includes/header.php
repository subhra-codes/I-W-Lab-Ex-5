<?php
$pageTitle = $pageTitle ?? "EmployeeHub";
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | EmployeeHub</title>
    <meta name="description" content="Modern employee management lab exercise using PHP and MySQL.">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="container nav-wrap">
        <a class="brand" href="index.php">
            <span class="brand-mark">E</span>
            <span>
                <strong>EmployeeHub</strong>
                <small>Management Portal</small>
            </span>
        </a>
        <nav class="nav">
            <a class="<?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">Add Employee</a>
            <a class="<?= $currentPage === 'admin.php' ? 'active' : '' ?>" href="admin.php">Admin Dashboard</a>
        </nav>
    </div>
</header>
<main class="container page">
