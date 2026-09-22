<?php

if (getenv("DATABASE_URL")) {

    // Render PostgreSQL
    $databaseUrl = parse_url(getenv("DATABASE_URL"));

    $host = $databaseUrl["host"];
    $port = $databaseUrl["port"] ?? 5432;
    $user = $databaseUrl["user"];
    $pass = $databaseUrl["pass"];
    $db   = ltrim($databaseUrl["path"], "/");

    $dsn = "pgsql:host=$host;port=$port;dbname=$db";

} else {

    // Local XAMPP MySQL
    $host = "localhost";
    $db   = "employee_db";
    $user = "root";
    $pass = "";

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
}

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {

    die("Database connection failed.");
}