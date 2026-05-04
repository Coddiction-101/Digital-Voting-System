<?php
require_once __DIR__ . '/../includes/session.php';

$admin = require_role($conn, 'admin', '../login.html');
$flash = get_flash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $action = $_POST['action'] ?? 'create';

    if ($action === 'create') {
        $name = trim($_POST['election_name'] ?? '');
        $type = trim($_POST['election_type'] ?? '');
        $start = $_POST['start_date'] ?? '';
        $end = $_POST['end_date'] ?? '';
        $status = $_POST['status'] ?? 'upcoming';
        $description = trim($_POST['description'] ?? '');

        if ($name !== '' && $start !== '' && $end !== '') {
            $stmt = mysqli_prepare($conn, 'INSERT INTO elections (election_name, election_type, start_date, end_date, status, description, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'ssssssi', $name, $type, $start, $end, $status, $description, $admin['user_id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            log_admin_action($conn, $admin['user_id'], 'Created election', $name);
            redirect_with_message('manage_elections.php', 'success', 'Election created successfully.');
        }
    }

    if ($action === 'status') {
        $election_id = (int) ($_POST['election_id'] ?? 0);
        $status = $_POST['status'] ?? 'upcoming';
        $allowed = ['upcoming', 'active', 'completed'];

        if ($election_id > 0 && in_array($status, $allowed, true)) {
            $stmt = mysqli_prepare($conn, 'UPDATE elections SET status = ? WHERE election_id = ?');
            mysqli_stmt_bind_param($stmt, 'si', $status, $election_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            log_admin_action($conn, $admin['user_id'], 'Updated election status', 'Election ID ' . $election_id . ' set to ' . $status);
            redirect_with_message('manage_elections.php', 'success', 'Election status updated.');
        }
    }

    if ($action === 'delete') {
        $election_id = (int) ($_POST['election_id'] ?? 0);

        if ($election_id > 0) {
            $stmt = mysqli_prepare($conn, 'DELETE FROM elections WHERE election_id = ?');
            mysqli_stmt_bind_param($stmt, 'i', $election_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            log_admin_action($conn, $admin['user_id'], 'Deleted election', 'Election ID ' . $election_id);
            redirect_with_message('manage_elections.php', 'success', 'Election deleted.');
        }
    }

    redirect_with_message('manage_elections.php', 'error', 'Please fill the required fields.');
}

$elections = mysqli_query($conn, 'SELECT * FROM elections ORDER BY start_date DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Elections</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body class="admin-shell">
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
    <div class="dashboard-container">
        <header class="header">
            <div class="logo">Manage Elections</div>
            <a href="dashboard.php">Admin Dashboard</a>
        </header>

        <?php if ($flash): ?>
            <section class="flash <?php echo h($flash['type']); ?>"><?php echo h($flash['message']); ?></section>
        <?php endif; ?>

        <section>
            <header class="section-header"><h2>Create Election</h2></header>
            <form method="POST" class="form-grid">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="action" value="create" />
                <input name="election_name" placeholder="Election name" required />
                <input name="election_type" placeholder="Election type" />
                <input type="datetime-local" name="start_date" required />
                <input type="datetime-local" name="end_date" required />
                <select name="status">
                    <option value="upcoming">Upcoming</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
                <textarea name="description" placeholder="Description"></textarea>
                <button class="btn primary full-row" type="submit">Create Election</button>
            </form>
        </section>

        <section>
            <header class="section-header"><h2>All Elections</h2></header>
            <div class="table-list">
                <?php while ($election = mysqli_fetch_assoc($elections)): ?>
                    <div class="card-election">
                        <div class="admin-card-title">
                            <h3><?php echo h($election['election_name']); ?></h3>
                            <span class="status <?php echo $election['status'] === 'active' ? 'live' : 'upcoming'; ?>"><?php echo h(ucfirst($election['status'])); ?></span>
                        </div>
                        <p><?php echo h($election['start_date']); ?> to <?php echo h($election['end_date']); ?></p>
                        <div class="row-actions">
                            <form method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="status" />
                                <input type="hidden" name="election_id" value="<?php echo (int) $election['election_id']; ?>" />
                                <select name="status">
                                    <option value="upcoming" <?php echo $election['status'] === 'upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                                    <option value="active" <?php echo $election['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="completed" <?php echo $election['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                </select>
                                <button class="btn secondary" type="submit">Update</button>
                            </form>
                            <form method="POST" onsubmit="return confirm('Delete this election and its candidates/votes?');">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="action" value="delete" />
                                <input type="hidden" name="election_id" value="<?php echo (int) $election['election_id']; ?>" />
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

