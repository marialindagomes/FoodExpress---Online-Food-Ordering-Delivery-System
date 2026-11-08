<?php
require_once "config.php";

if (session_status() === PHP_SESSION_NONE)
    session_start();

function require_login()
{
    if (empty($_SESSION['user'])) {
        header("Location: " . BASE_URL . "/login.php");
        exit;
    }
}

function require_role($role)
{
    require_login();
    if ($_SESSION['user']['role'] !== $role) {
        http_response_code(403);
        exit("Access denied.");
    }
}

function current_user()
{
    return $_SESSION['user'] ?? null;
}
