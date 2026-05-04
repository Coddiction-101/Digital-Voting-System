<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.html');
    exit();
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (strlen($name) < 3) {
    redirect_with_message('../register.html', 'error', 'Full name must be at least 3 characters.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect_with_message('../register.html', 'error', 'Please enter a valid email address.');
}

if (strlen($password) < 6) {
    redirect_with_message('../register.html', 'error', 'Password must be at least 6 characters.');
}

if ($password !== $confirm_password) {
    redirect_with_message('../register.html', 'error', 'Passwords do not match.');
}

$stmt = mysqli_prepare($conn, 'SELECT user_id FROM users WHERE email = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    mysqli_stmt_close($stmt);
    redirect_with_message('../register.html', 'error', 'An account already exists with this email.');
}

mysqli_stmt_close($stmt);

$voter_id = generate_voter_id($conn);
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$is_verified = 1;

$stmt = mysqli_prepare($conn, 'INSERT INTO users (voter_id, full_name, email, password, is_verified) VALUES (?, ?, ?, ?, ?)');
mysqli_stmt_bind_param($stmt, 'ssssi', $voter_id, $name, $email, $password_hash, $is_verified);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    redirect_with_message('../register.html', 'error', 'Registration failed. Please try again.');
}

mysqli_stmt_close($stmt);
redirect_with_message('../login.html', 'success', 'Registration successful. Your voter ID is ' . $voter_id . '.');
?>

