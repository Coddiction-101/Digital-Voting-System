<?php
$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$is_admin_area = strpos($script, '/admin/') !== false;
$base = $is_admin_area ? '../' : '';
$nav_user = isset($conn) ? current_user($conn) : null;
$role = $nav_user['role'] ?? 'guest';
?>
<nav class="app-nav">
    <a class="brand" href="<?php echo $base; ?>dashboard.php">Digital Voting System</a>
    <div class="nav-links">
        <?php if ($role === 'admin'): ?>
            <a href="<?php echo $base; ?>admin/dashboard.php">Admin</a>
            <a href="<?php echo $base; ?>admin/manage_elections.php">Elections</a>
            <a href="<?php echo $base; ?>admin/manage_candidates.php">Candidates</a>
            <a href="<?php echo $base; ?>admin/voters.php">Voters</a>
            <a href="<?php echo $base; ?>admin/analytics.php">Analytics</a>
            <a href="<?php echo $base; ?>admin/settings.php">Settings</a>
            <a href="<?php echo $base; ?>results.php">Results</a>
        <?php elseif ($role === 'voter'): ?>
            <a href="<?php echo $base; ?>dashboard.php">Dashboard</a>
            <a href="<?php echo $base; ?>vote.php">Vote</a>
            <a href="<?php echo $base; ?>results.php">Results</a>
        <?php endif; ?>
        <button type="button" class="theme-toggle" id="themeToggle">Theme</button>
        <?php if ($nav_user): ?>
            <a href="<?php echo $base; ?>php/logout.php">Logout</a>
        <?php endif; ?>
    </div>
</nav>

