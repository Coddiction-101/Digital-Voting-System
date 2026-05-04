<?php
require_once __DIR__ . '/../includes/session.php';

$admin = require_role($conn, 'admin', '../login.html');
$flash = get_flash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? 'create';

    if ($action === 'create') {
        $election_id = (int) ($_POST['election_id'] ?? 0);
        $name = trim($_POST['candidate_name'] ?? '');
        $party = trim($_POST['party_name'] ?? '');
        $bio = trim($_POST['bio'] ?? '');

        if ($election_id > 0 && $name !== '') {
            $stmt = mysqli_prepare($conn, 'INSERT INTO candidates (election_id, candidate_name, party_name, bio) VALUES (?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'isss', $election_id, $name, $party, $bio);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            log_admin_action($conn, $admin['user_id'], 'Added candidate', $name);
            redirect_with_message('manage_candidates.php', 'success', 'Candidate added successfully.');
        }
    }

    if ($action === 'delete') {
        $candidate_id = (int) ($_POST['candidate_id'] ?? 0);

        if ($candidate_id > 0) {
            $stmt = mysqli_prepare($conn, 'DELETE FROM candidates WHERE candidate_id = ?');
            mysqli_stmt_bind_param($stmt, 'i', $candidate_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            log_admin_action($conn, $admin['user_id'], 'Deleted candidate', 'Candidate ID ' . $candidate_id);
            redirect_with_message('manage_candidates.php', 'success', 'Candidate deleted.');
        }
    }

    redirect_with_message('manage_candidates.php', 'error', 'Please fill the required fields.');
}

$elections = mysqli_query($conn, 'SELECT election_id, election_name FROM elections ORDER BY election_name ASC');
$candidates = mysqli_query($conn, "
    SELECT c.candidate_id, c.candidate_name, c.party_name, c.vote_count, e.election_name
    FROM candidates c
    JOIN elections e ON e.election_id = c.election_id
    ORDER BY e.election_name, c.candidate_name
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Candidates</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-shell">
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">Manage Candidates</div>
            <a href="dashboard.php">Admin Dashboard</a>
        </header>

        <?php if ($flash): ?>
            <section class="flash <?php echo h($flash['type']); ?>"><?php echo h($flash['message']); ?></section>
        <?php endif; ?>

        <section>
            <header class="section-header"><h2>Add Candidate</h2></header>
            <form method="POST" class="form-grid">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="create" />
                <select name="election_id" required>
                    <option value="">Select election</option>
                    <?php while ($election = mysqli_fetch_assoc($elections)): ?>
                        <option value="<?php echo (int) $election['election_id']; ?>"><?php echo h($election['election_name']); ?></option>
                    <?php endwhile; ?>
                </select>
                <input name="candidate_name" placeholder="Candidate name" required />
                <input name="party_name" placeholder="Party name" />
                <textarea name="bio" placeholder="Candidate bio"></textarea>
                <button class="btn primary full-row" type="submit">Add Candidate</button>
            </form>
        </section>

        <section>
            <header class="section-header"><h2>Candidates</h2></header>
            <div class="table-list">
                <?php while ($candidate = mysqli_fetch_assoc($candidates)): ?>
                    <div class="card-election">
                        <div class="admin-card-title">
                            <h3><?php echo h($candidate['candidate_name']); ?></h3>
                            <span class="status upcoming"><?php echo (int) $candidate['vote_count']; ?> votes</span>
                        </div>
                        <p><?php echo h($candidate['party_name']); ?> | <?php echo h($candidate['election_name']); ?></p>
                        <div class="row-actions">
                            <form method="POST" onsubmit="return confirm('Delete this candidate?');">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="delete" />
                                <input type="hidden" name="candidate_id" value="<?php echo (int) $candidate['candidate_id']; ?>" />
                                <button class="btn danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>
    <script src="../js/main.js"></script>
</body>
</html>

