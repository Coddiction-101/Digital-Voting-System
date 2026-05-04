<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirect_with_message('../login.html', 'error', 'Please enter a valid email for password recovery.');
    }

    $stmt = mysqli_prepare($conn, 'SELECT user_id FROM users WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    if ($exists) {
        redirect_with_message('../login.html', 'success', 'Password recovery request received. Please contact the admin for reset.');
    }

    redirect_with_message('../login.html', 'error', 'No account was found with that email.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="login-header">
                <h1>Password Recovery</h1>
                <p>Enter your registered email</p>
            </div>
            <form method="POST">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Registered email" required />
                </div>
                <button class="login-btn" type="submit">Submit Request</button>
                <div class="register-link"><a href="../login.html">Back to login</a></div>
            </form>
        </div>
    </div>
</body>
</html>

