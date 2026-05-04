<?php
session_start();
require_once __DIR__ . '/php/config.php';
require_once __DIR__ . '/php/functions.php';

$flash = get_flash();
$elections = mysqli_query($conn, "
    SELECT election_id, election_name, status, end_date
    FROM elections
    ORDER BY end_date DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Election Results - Digital Voting System</title>
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">Election Results</div>
            <a href="dashboard.php">Dashboard</a>
        </header>

        <?php if ($flash): ?>
            <section class="flash <?php echo h($flash['type']); ?>"><?php echo h($flash['message']); ?></section>
        <?php endif; ?>

        <main class="main-content">
            <?php while ($election = mysqli_fetch_assoc($elections)): ?>
                <?php
                $stmt = mysqli_prepare($conn, 'SELECT candidate_name, party_name, vote_count FROM candidates WHERE election_id = ? ORDER BY vote_count DESC, candidate_name ASC');
                mysqli_stmt_bind_param($stmt, 'i', $election['election_id']);
                mysqli_stmt_execute($stmt);
                $candidates = mysqli_stmt_get_result($stmt);
                $total_votes = 0;
                $rows = [];

                while ($candidate = mysqli_fetch_assoc($candidates)) {
                    $total_votes += (int) $candidate['vote_count'];
                    $rows[] = $candidate;
                }

                mysqli_stmt_close($stmt);
                ?>
                <section>
                    <header class="section-header">
                        <h2><?php echo h($election['election_name']); ?></h2>
                        <span><?php echo h(ucfirst($election['status'])); ?></span>
                    </header>
                    <?php foreach ($rows as $candidate): ?>
                        <?php $percent = $total_votes > 0 ? round(((int) $candidate['vote_count'] / $total_votes) * 100, 1) : 0; ?>
                        <div style="margin:14px 0;">
                            <strong><?php echo h($candidate['candidate_name']); ?></strong>
                            <span><?php echo h($candidate['party_name']); ?></span>
                            <div><?php echo (int) $candidate['vote_count']; ?> votes (<?php echo $percent; ?>%)</div>
                            <div class="result-bar">
                                <div class="result-fill" style="width:<?php echo $percent; ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <small>Total votes: <?php echo $total_votes; ?></small>
                </section>
            <?php endwhile; ?>
        </main>
    </div>
    <script src="js/main.js"></script>
    <script src="js/charts.js"></script>
</body>
</html>

