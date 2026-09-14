<?php
function esc($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function app_url($query = '') {
    $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    $query = ltrim((string)$query, '?');
    return $script . ($query !== '' ? '?' . $query : '');
}

function redirect($url) {
    if (strpos($url, 'index.php') === 0) {
        $query = substr($url, strlen('index.php'));
        $url = app_url($query);
    }
    header('Location: ' . $url);
    exit;
}

function is_logged_in() {
    return isset($_SESSION['user_id'], $_SESSION['role']);
}

function require_login() {
    if (!is_logged_in()) {
        flash('error', 'Please log in first.');
        redirect(app_url('page=login'));
    }
}

function require_role($roles) {
    require_login();
    $roles = (array)$roles;
    if (!in_array($_SESSION['role'], $roles, true)) {
        flash('error', 'You are not authorized to access that page.');
        redirect(app_url());
    }
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf() {
    $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        die('Invalid CSRF token.');
    }
}

function flash($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

function get_flash($type) {
    $message = $_SESSION['flash'][$type] ?? '';
    unset($_SESSION['flash'][$type]);
    return $message;
}

function check_session_timeout() {
    if (!is_logged_in()) return;
    if (isset($_SESSION['last_activity']) &&
        time() - $_SESSION['last_activity'] > SESSION_TIMEOUT) {
        $_SESSION = [];
        session_destroy();
        session_start();
        flash('error', 'Your session expired. Please log in again.');
        redirect(app_url('page=login'));
    }
    $_SESSION['last_activity'] = time();
}

function old($key) {
    return esc($_POST[$key] ?? '');
}

function current_user_id() {
    return (int)($_SESSION['user_id'] ?? 0);
}

function role_dashboard($role) {
    return match ($role) {
        'admin' => 'admin',
        'event_manager' => 'manager',
        'volunteer' => 'volunteer',
        default => 'dashboard'
    };
}
?>
