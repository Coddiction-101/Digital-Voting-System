<?php
require_once __DIR__ . '/../includes/session.php';

require_role($conn, 'admin', '../login.html');

$election_stats = mysqli_query($conn, "
    SELECT e.election_name, e.status, COUNT(v.vote_id) AS total_votes
    FROM elections e
    LEFT JOIN votes v ON v.election_id = e.election_id
    GROUP BY e.election_id
    ORDER BY total_votes DESC, e.election_name ASC
");

$participation = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT
        (SELECT COUNT(*) FROM users WHERE role = 'voter') AS total_voters,
        (SELECT COUNT(DISTINCT voter_id) FROM votes) AS voted_voters
"));

$total_voters = (int) $participation['total_voters'];
$voted_voters = (int) $participation['voted_voters'];
$participation_rate = $total_voters > 0 ? round(($voted_voters / $total_voters) * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Analytics - Admin</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-shell">
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">Analytics</div>
            <a href="dashboard.php">Admin Dashboard</a>
        </header>

        <section class="stats-overview">
            <div class="card admin-stat">
                <div class="content">
                    <h3>Participation</h3>
                    <p class="number"><?php echo $participation_rate; ?>%</p>
                    <small><?php echo $voted_voters; ?> of <?php echo $total_voters; ?> voters participated</small>
                </div>
            </div>
        </section>

        <section>
            <header class="section-header"><h2>Election Vote Summary</h2></header>
            <div class="table-list">
                <?php while ($row = mysqli_fetch_assoc($election_stats)): ?>
                    <div class="card-election">
                        <div class="admin-card-title">
                            <h3><?php echo h($row['election_name']); ?></h3>
                            <span class="status <?php echo $row['status'] === 'active' ? 'live' : 'upcoming'; ?>"><?php echo h(ucfirst($row['status'])); ?></span>
                        </div>
                        <p>Total votes: <?php echo (int) $row['total_votes']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>

