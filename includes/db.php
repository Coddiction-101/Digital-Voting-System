<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'voting_system';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    die('Database connection failed. Please try again later.');
}

mysqli_set_charset($conn, 'utf8mb4');
?>

