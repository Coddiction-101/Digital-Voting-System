<?php
function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect_with_message($url, $type, $message)
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];

    if (substr(parse_url($url, PHP_URL_PATH), -5) === '.html') {
        $separator = strpos($url, '?') !== false ? '&' : '?';
        $url .= $separator . http_build_query([
            'type' => $type,
            'message' => $message,
        ]);
    }

    header('Location: ' . $url);
    exit();
}

function get_flash()
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

function verify_csrf()
{
    $token = $_POST['csrf_token'] ?? '';

    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die('Invalid form request. Please go back and try again.');
    }
}

function generate_voter_id($conn)
{
    do {
        $voter_id = 'VTR' . date('Y') . random_int(1000, 9999);
        $stmt = mysqli_prepare($conn, 'SELECT user_id FROM users WHERE voter_id = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $voter_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $exists = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);
    } while ($exists);

    return $voter_id;
}

function current_user($conn)
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }

    $stmt = mysqli_prepare($conn, 'SELECT user_id, voter_id, full_name, email, role, has_voted FROM users WHERE user_id = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $user ?: null;
}

function require_login($conn, $redirect = 'login.html')
{
    $user = current_user($conn);

    if (!$user) {
        header('Location: ' . $redirect);
        exit();
    }

    return $user;
}

function require_role($conn, $role, $redirect = '../login.html')
{
    $user = require_login($conn, $redirect);

    if ($user['role'] !== $role) {
        header('Location: ' . $redirect);
        exit();
    }

    return $user;
}

function log_admin_action($conn, $admin_id, $action, $details = '')
{
    $stmt = mysqli_prepare($conn, 'INSERT INTO admin_logs (admin_id, action, details) VALUES (?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'iss', $admin_id, $action, $details);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>

