<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.html');
    exit();
}

$identifier = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($identifier === '' || $password === '') {
    redirect_with_message('../login.html', 'error', 'Email/Voter ID and password are required.');
}

$stmt = mysqli_prepare($conn, 'SELECT user_id, voter_id, full_name, email, password, role, is_verified FROM users WHERE email = ? OR voter_id = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'ss', $identifier, $identifier);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user || !password_verify($password, $user['password'])) {
    redirect_with_message('../login.html', 'error', 'Invalid credentials.');
}

if ((int) $user['is_verified'] !== 1) {
    redirect_with_message('../login.html', 'error', 'Your account is not verified yet.');
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['user_id'];
$_SESSION['role'] = $user['role'];
$_SESSION['last_activity'] = time();

if ($user['role'] === 'admin') {
    header('Location: ../admin/dashboard.php');
    exit();
}

header('Location: ../dashboard.php');
exit();
?>

