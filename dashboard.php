<?php
require_once __DIR__ . '/includes/session.php';

$user = require_role($conn, 'voter', 'login.html');

$stats = [
    'active' => 0,
    'upcoming' => 0,
    'votes' => 0,
    'participation' => 0,
];

$stats['active'] = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM elections WHERE status = 'active' AND start_date <= NOW() AND end_date >= NOW()"))['total'];
$stats['upcoming'] = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM elections WHERE status = 'upcoming' OR start_date > NOW()"))['total'];

$stmt = mysqli_prepare($conn, 'SELECT COUNT(*) AS total FROM votes WHERE voter_id = ?');
mysqli_stmt_bind_param($stmt, 's', $user['voter_id']);
mysqli_stmt_execute($stmt);
$stats['votes'] = (int) mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'];
mysqli_stmt_close($stmt);

$total_voters = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'voter'"))['total'];
$voted_users = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT voter_id) AS total FROM votes"))['total'];
$stats['participation'] = $total_voters > 0 ? round(($voted_users / $total_voters) * 100) : 0;

$elections = mysqli_query($conn, "
    SELECT e.*, COUNT(c.candidate_id) AS candidate_total
    FROM elections e
    LEFT JOIN candidates c ON c.election_id = e.election_id
    WHERE e.status IN ('active', 'upcoming')
    GROUP BY e.election_id
    ORDER BY e.start_date ASC
    LIMIT 6
");

$initials = implode('', array_map(function ($part) {
    return strtoupper(substr($part, 0, 1));
}, array_slice(explode(' ', $user['full_name']), 0, 2)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Voter Dashboard - Digital Voting System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">
                <i class="fas fa-vote-yea"></i>
                <span>Digital Voting System</span>
            </div>
            <div class="user-info">
                <div class="avatar"><?php echo h($initials ?: 'V'); ?></div>
                <div class="user-details">
                    <div class="name"><?php echo h($user['full_name']); ?></div>
                    <div class="id">Voter ID: <?php echo h($user['voter_id']); ?></div>
                </div>
            </div>
        </header>

        <section class="stats-overview">
            <div class="card">
                <div class="icon"><i class="fas fa-poll"></i></div>
                <div class="content"><h3>Active Elections</h3><p class="number"><?php echo $stats['active']; ?></p></div>
            </div>
            <div class="card">
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <div class="content"><h3>Your Votes</h3><p class="number"><?php echo $stats['votes']; ?></p></div>
            </div>
            <div class="card">
                <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="content"><h3>Upcoming</h3><p class="number"><?php echo $stats['upcoming']; ?></p></div>
            </div>
            <div class="card">
                <div class="icon"><i class="fas fa-users"></i></div>
                <div class="content"><h3>Participation</h3><p class="number"><?php echo $stats['participation']; ?>%</p></div>
            </div>
        </section>

        <main class="main-content">
            <section class="elections">
                <header class="section-header">
                    <h2><i class="fas fa-fire"></i> Elections</h2>
                    <a href="results.php">View Results &rarr;</a>
                </header>
                <div class="cards-grid">
                    <?php while ($election = mysqli_fetch_assoc($elections)): ?>
                        <?php $is_active = $election['status'] === 'active' && strtotime($election['start_date']) <= time() && strtotime($election['end_date']) >= time(); ?>
                        <div class="card-election">
                            <div class="election-header">
                                <div>
                                    <h3><?php echo h($election['election_name']); ?></h3>
                                    <div class="meta-info">
                                        <div><i class="fas fa-users"></i> <?php echo (int) $election['candidate_total']; ?> Candidates</div>
                                        <div><i class="fas fa-clock"></i> Ends <?php echo h(date('M d, Y', strtotime($election['end_date']))); ?></div>
                                    </div>
                                </div>
                                <div class="status <?php echo $is_active ? 'live' : 'upcoming'; ?>"><?php echo $is_active ? 'Live' : 'Upcoming'; ?></div>
                            </div>
                            <?php if ($is_active): ?>
                                <a class="btn primary" href="vote.php?election_id=<?php echo (int) $election['election_id']; ?>"><i class="fas fa-vote-yea"></i> Vote Now</a>
                            <?php else: ?>
                                <button class="btn disabled" disabled><i class="fas fa-hourglass-half"></i> Not Started</button>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>
</html>

