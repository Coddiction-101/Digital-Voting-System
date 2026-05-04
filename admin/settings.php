<?php
require_once __DIR__ . '/../includes/session.php';

require_role($conn, 'admin', '../login.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings - Admin</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-shell">
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">System Settings</div>
            <a href="dashboard.php">Admin Dashboard</a>
        </header>

        <section>
            <header class="section-header"><h2>Project Configuration</h2></header>
            <div class="table-list">
                <div class="card-election">
                    <h3>Voting Rule</h3>
                    <p>One voter can cast one vote per election.</p>
                </div>
                <div class="card-election">
                    <h3>Session Timeout</h3>
                    <p>Users are logged out after 30 minutes of inactivity.</p>
                </div>
                <div class="card-election">
                    <h3>Security</h3>
                    <p>Passwords are hashed and voting/admin forms use CSRF tokens.</p>
                </div>
            </div>
        </section>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>

