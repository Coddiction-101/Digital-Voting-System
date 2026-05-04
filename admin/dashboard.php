<?php
require_once __DIR__ . '/../includes/session.php';

$admin = require_role($conn, 'admin', '../login.html');

$total_voters = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'voter'"))['total'];
$total_elections = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM elections"))['total'];
$active_elections = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM elections WHERE status = 'active'"))['total'];
$total_votes = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM votes"))['total'];
$recent_votes = mysqli_query($conn, "
    SELECT v.voted_at, v.voter_id, e.election_name, c.candidate_name
    FROM votes v
    JOIN elections e ON e.election_id = v.election_id
    JOIN candidates c ON c.candidate_id = v.candidate_id
    ORDER BY v.voted_at DESC
    LIMIT 8
");
$logs = mysqli_query($conn, "
    SELECT l.action, l.details, l.timestamp, u.full_name
    FROM admin_logs l
    JOIN users u ON u.user_id = l.admin_id
    ORDER BY l.timestamp DESC
    LIMIT 6
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - Digital Voting System</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-shell">
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">Admin Dashboard</div>
            <div class="user-details">
                <div><?php echo h($admin['full_name']); ?></div>
            </div>
        </header>

        <section class="stats-overview">
            <div class="card admin-stat"><div class="content"><h3>Voters</h3><p class="number"><?php echo $total_voters; ?></p><small>Registered voter accounts</small></div></div>
            <div class="card admin-stat"><div class="content"><h3>Elections</h3><p class="number"><?php echo $total_elections; ?></p><small>Total elections created</small></div></div>
            <div class="card admin-stat"><div class="content"><h3>Active</h3><p class="number"><?php echo $active_elections; ?></p><small>Open for voting</small></div></div>
            <div class="card admin-stat"><div class="content"><h3>Votes</h3><p class="number"><?php echo $total_votes; ?></p><small>Votes recorded</small></div></div>
        </section>

        <main class="main-content">
            <section>
                <header class="section-header">
                    <h2>Admin Controls</h2>
                    <a href="../results.php">Public Results</a>
                </header>
                <div class="actions-grid admin-actions">
                    <a class="action-card" href="manage_elections.php"><h4>Elections</h4><p>Create and update elections</p></a>
                    <a class="action-card" href="manage_candidates.php"><h4>Candidates</h4><p>Add or remove candidates</p></a>
                    <a class="action-card" href="voters.php"><h4>Voters</h4><p>View registered voters</p></a>
                    <a class="action-card" href="../results.php"><h4>Results</h4><p>Check vote counts</p></a>
                </div>
            </section>

            <section>
                <header class="section-header">
                    <h2>Recent Voting Activity</h2>
                    <a href="../results.php">Results</a>
                </header>
                <?php if (mysqli_num_rows($recent_votes) === 0): ?>
                    <p class="admin-empty">No votes have been cast yet.</p>
                <?php endif; ?>
                <?php while ($vote = mysqli_fetch_assoc($recent_votes)): ?>
                    <p class="vote-item">
                        <?php echo h($vote['voter_id']); ?> voted in
                        <strong><?php echo h($vote['election_name']); ?></strong>
                        at <?php echo h(date('M d, Y h:i A', strtotime($vote['voted_at']))); ?>.
                    </p>
                <?php endwhile; ?>
            </section>

            <section>
                <header class="section-header"><h2>Admin Activity Logs</h2></header>
                <?php if (mysqli_num_rows($logs) === 0): ?>
                    <p class="admin-empty">No admin activity logged yet.</p>
                <?php endif; ?>
                <?php while ($log = mysqli_fetch_assoc($logs)): ?>
                    <p class="log-item">
                        <strong><?php echo h($log['action']); ?></strong>
                        by <?php echo h($log['full_name']); ?>
                        at <?php echo h(date('M d, Y h:i A', strtotime($log['timestamp']))); ?>
                    </p>
                    <?php if ($log['details']): ?>
                        <small><?php echo h($log['details']); ?></small>
                    <?php endif; ?>
                <?php endwhile; ?>
            </section>
        </main>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>

