<?php
require_once __DIR__ . '/includes/session.php';

$user = require_role($conn, 'voter', 'login.html');
$flash = get_flash();
$selected_election_id = (int) ($_GET['election_id'] ?? 0);

$election_filter = $selected_election_id > 0 ? 'AND e.election_id = ' . $selected_election_id : '';
$elections = mysqli_query($conn, "
    SELECT e.*
    FROM elections e
    WHERE e.status = 'active'
      AND e.start_date <= NOW()
      AND e.end_date >= NOW()
      $election_filter
    ORDER BY e.end_date ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vote Now - Digital Voting System</title>
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>
    <?php include __DIR__ . '/includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">Digital Voting System</div>
            <a href="dashboard.php">Back to Dashboard</a>
        </header>

        <?php if ($flash): ?>
            <section class="flash <?php echo h($flash['type']); ?>"><?php echo h($flash['message']); ?></section>
        <?php endif; ?>

        <main class="main-content">
            <section>
                <header class="section-header"><h2>Cast Your Vote</h2></header>

                <?php if (mysqli_num_rows($elections) === 0): ?>
                    <p>No active elections are available right now.</p>
                <?php endif; ?>

                <?php while ($election = mysqli_fetch_assoc($elections)): ?>
                    <?php
                    $stmt = mysqli_prepare($conn, 'SELECT vote_id FROM votes WHERE election_id = ? AND voter_id = ? LIMIT 1');
                    mysqli_stmt_bind_param($stmt, 'is', $election['election_id'], $user['voter_id']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $already_voted = mysqli_stmt_num_rows($stmt) > 0;
                    mysqli_stmt_close($stmt);

                    $stmt = mysqli_prepare($conn, 'SELECT candidate_id, candidate_name, party_name, bio FROM candidates WHERE election_id = ? ORDER BY candidate_name ASC');
                    mysqli_stmt_bind_param($stmt, 'i', $election['election_id']);
                    mysqli_stmt_execute($stmt);
                    $candidates = mysqli_stmt_get_result($stmt);
                    ?>
                    <div class="card-election">
                        <h3><?php echo h($election['election_name']); ?></h3>
                        <p><?php echo h($election['description']); ?></p>

                        <?php if ($already_voted): ?>
                            <p>You have already voted in this election.</p>
                        <?php else: ?>
                            <form method="POST" action="php/cast_vote.php">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="election_id" value="<?php echo (int) $election['election_id']; ?>" />
                                <?php while ($candidate = mysqli_fetch_assoc($candidates)): ?>
                                    <label class="candidate-option">
                                        <input type="radio" name="candidate_id" value="<?php echo (int) $candidate['candidate_id']; ?>" required />
                                        <strong><?php echo h($candidate['candidate_name']); ?></strong>
                                        <?php if ($candidate['party_name']): ?>
                                            <span> - <?php echo h($candidate['party_name']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($candidate['bio']): ?>
                                            <small><?php echo h($candidate['bio']); ?></small>
                                        <?php endif; ?>
                                    </label>
                                <?php endwhile; ?>
                                <button class="btn primary" type="submit">Submit Vote</button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php mysqli_stmt_close($stmt); ?>
                <?php endwhile; ?>
            </section>
        </main>
    </div>
    <script src="js/main.js"></script>
    <script src="js/vote.js"></script>
</body>
</html>

