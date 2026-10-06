<?php
// core/core.php
// Task 2 / Task 4: included on every page.
// Starts the session, sets the timezone, requires db_class, and defines the
// shared helper functions every controller/action/view can call.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('UTC');

require_once __DIR__ . '/db_class.php';


// Shared helpers


function get_ip()
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}


// Task 4: access control


function is_logged_in()
{
    return isset($_SESSION['customer_id']);
}

function is_admin()
{
    return is_logged_in() && (int) $_SESSION['user_role'] === 1;
}

function require_login()
{
    if (!is_logged_in()) {
        redirect(base_url('views/login.php'));
    }
}

function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = 'You do not have permission to view that page.';
        redirect(base_url('index.php'));
    }
}


function base_url($path = '')
{
    static $base = null;

    if ($base === null) {
        $script = $_SERVER['SCRIPT_NAME'];
        $position = strpos($script, '/shoppn/');
        $base = $position !== false
            ? substr($script, 0, $position + strlen('/shoppn/'))
            : '/';
    }

    return $base . ltrim($path, '/');
}
