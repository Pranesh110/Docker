<?php

$servername = getenv("DB_HOST") ?: "db";
$username   = getenv("DB_USER") ?: "appuser";
$password   = getenv("DB_PASSWORD") ?: "pass@123";
$dbname     = getenv("DB_NAME") ?: "student_db";

$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

if ($conn->connect_error) {
    http_response_code(500);

    die(json_encode([
        "message" => "Database connection failed"
    ]));
}

$conn->set_charset("utf8mb4");
?>