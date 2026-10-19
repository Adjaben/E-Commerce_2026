<?php

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

function upload_product_image($file)
{
    $maxSize = 2 * 1024 * 1024; // 2MB
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'error' => 'Please choose an image.'];
    }

    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE || $file['size'] > $maxSize) {
        return ['ok' => false, 'error' => 'Image must be 2MB or smaller.'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'Upload failed. Please try again.'];
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!isset($allowed[$mime])) {
        return ['ok' => false, 'error' => 'Only JPG, PNG, GIF or WEBP images are allowed.'];
    }

    $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
    $filename = uniqid() . '_' . ($safeName !== '' ? $safeName : 'image') . '.' . $allowed[$mime];

    if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../images/products/' . $filename)) {
        return ['ok' => false, 'error' => 'Could not save the image.'];
    }

    return ['ok' => true, 'filename' => $filename];
}

function redirect_back($fallback = 'index.php')
{
    $ref     = $_SERVER['HTTP_REFERER'] ?? '';
    $refHost = parse_url($ref, PHP_URL_HOST);
    $myHost  = parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);

    if ($ref !== '' && $refHost && $refHost === $myHost) {
        redirect($ref);
    }

    redirect(base_url($fallback));
}
