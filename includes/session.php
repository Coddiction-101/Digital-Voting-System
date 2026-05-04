<?php
session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../php/functions.php';

if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}

if (time() - $_SESSION['last_activity'] > 1800) {
    session_unset();
    session_destroy();
    $login_path = strpos($_SERVER['SCRIPT_NAME'] ?? '', '/admin/') !== false ? '../login.html' : 'login.html';
    header('Location: ' . $login_path);
    exit();
}

$_SESSION['last_activity'] = time();
?>

