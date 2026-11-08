<?php
require "../includes/config.php";
require "../config/database.php";
header("Content-Type: application/json");
session_start();
$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6 || $password !== $confirm) {
        echo json_encode(["ok" => false, "message" => "Please provide valid information and matching password."]);
        exit;
    }
    try {
        $s = $pdo->prepare("INSERT INTO users(name,email,password,phone,address,role) VALUES(?,?,?,?,?,'customer')");
        $s->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $phone, $address]);
        echo json_encode(["ok" => true, "message" => "Registration successful."]);
    } catch (PDOException $e) {
        echo json_encode(["ok" => false, "message" => "Email already exists."]);
    }
    exit;
}

if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $s = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $s->execute([$email]);
    $u = $s->fetch();
    if ($u && password_verify($password, $u['password'])) {
        unset($u['password']);
        $_SESSION['user'] = $u;
        $url = BASE_URL . ($u['role'] === 'customer' ? '/customer/menu.php' : ($u['role'] === 'admin' ? '/admin/dashboard.php' : '/delivery/dashboard.php'));
        echo json_encode(["ok" => true, "url" => $url]);
    } else echo json_encode(["ok" => false, "message" => "Invalid email or password."]);
    exit;
}
echo json_encode(["ok" => false, "message" => "Invalid action."]);
