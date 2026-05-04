<?php
require_once __DIR__ . '/../includes/session.php';

require_role($conn, 'admin', '../login.html');

$voters = mysqli_query($conn, "
    SELECT user_id, voter_id, full_name, email, is_verified, has_voted, created_at
    FROM users
    WHERE role = 'voter'
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Voters - Admin</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-shell">
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">Voter Management</div>
            <a href="dashboard.php">Admin Dashboard</a>
        </header>
        <section>
            <header class="section-header"><h2>Registered Voters</h2></header>
            <?php while ($voter = mysqli_fetch_assoc($voters)): ?>
                <div class="card-election">
                    <div class="admin-card-title">
                        <h3><?php echo h($voter['full_name']); ?></h3>
                        <span class="status <?php echo $voter['has_voted'] ? 'live' : 'upcoming'; ?>"><?php echo $voter['has_voted'] ? 'Voted' : 'Pending'; ?></span>
                    </div>
                    <p><?php echo h($voter['email']); ?> | <?php echo h($voter['voter_id']); ?></p>
                    <small>
                        <?php echo $voter['is_verified'] ? 'Verified' : 'Not verified'; ?> |
                        <?php echo $voter['has_voted'] ? 'Has voted' : 'No vote yet'; ?>
                    </small>
                </div>
            <?php endwhile; ?>
        </section>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>

