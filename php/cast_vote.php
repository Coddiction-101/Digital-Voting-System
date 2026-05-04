<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$user = require_login($conn, '../login.html');
verify_csrf();

$election_id = (int) ($_POST['election_id'] ?? 0);
$candidate_id = (int) ($_POST['candidate_id'] ?? 0);

if ($election_id <= 0 || $candidate_id <= 0) {
    redirect_with_message('../vote.php', 'error', 'Please select a candidate before voting.');
}

$stmt = mysqli_prepare($conn, "SELECT candidate_id FROM candidates WHERE candidate_id = ? AND election_id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'ii', $candidate_id, $election_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 0) {
    mysqli_stmt_close($stmt);
    redirect_with_message('../vote.php', 'error', 'Invalid candidate selected.');
}

mysqli_stmt_close($stmt);

$voter_id = $user['voter_id'];
$ip_address = $_SERVER['REMOTE_ADDR'] ?? '';

mysqli_begin_transaction($conn);

try {
    $stmt = mysqli_prepare($conn, 'INSERT INTO votes (election_id, voter_id, candidate_id, ip_address) VALUES (?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'isis', $election_id, $voter_id, $candidate_id, $ip_address);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, 'UPDATE candidates SET vote_count = vote_count + 1 WHERE candidate_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $candidate_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, 'UPDATE users SET has_voted = 1 WHERE user_id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $user['user_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_commit($conn);
    redirect_with_message('../results.php', 'success', 'Your vote has been recorded successfully.');
} catch (mysqli_sql_exception $exception) {
    mysqli_rollback($conn);

    if ((int) $exception->getCode() === 1062) {
        redirect_with_message('../vote.php', 'error', 'You have already voted in this election.');
    }

    error_log($exception->getMessage());
    redirect_with_message('../vote.php', 'error', 'Vote could not be recorded. Please try again.');
}
?>

