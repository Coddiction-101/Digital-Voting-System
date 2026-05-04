<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$voter_id = trim($_GET['voter_id'] ?? '');

if ($voter_id === '') {
    redirect_with_message('../login.html', 'error', 'Verification link is invalid.');
}

$stmt = mysqli_prepare($conn, 'UPDATE users SET is_verified = 1 WHERE voter_id = ?');
mysqli_stmt_bind_param($stmt, 's', $voter_id);
mysqli_stmt_execute($stmt);
$updated = mysqli_stmt_affected_rows($stmt);
mysqli_stmt_close($stmt);

if ($updated > 0) {
    redirect_with_message('../login.html', 'success', 'Email verified successfully. You can log in now.');
}

redirect_with_message('../login.html', 'error', 'Account already verified or voter ID not found.');
?>

