<?php
// logout.php
// Task 2/4: destroys the session and redirects to index.php.

require_once __DIR__ . '/core/core.php';

$_SESSION = [];
session_destroy();

redirect(base_url('index.php'));
