<?php
require "../includes/auth.php";
require_login();
require "../config/database.php";
header("Content-Type: application/json");
$id = $_SESSION['user']['id'];
$a = $_POST['action'] ?? '';
if ($a === 'profile') {
   $s = $pdo->prepare("UPDATE users SET name=?,phone=?,address=? WHERE id=?");
   $s->execute([trim($_POST['name']), trim($_POST['phone']), trim($_POST['address']), $id]);
   $q = $pdo->prepare("SELECT id,name,email,phone,address,role FROM users WHERE id=?");
   $q->execute([$id]);
   $_SESSION['user'] = $q->fetch();
   echo json_encode(["ok" => true, "message" => "Profile updated."]);
   exit;
}
if ($a === 'password') {
   $s = $pdo->prepare("SELECT password FROM users WHERE id=?");
   $s->execute([$id]);
   $hash = $s->fetchColumn();
   if (!password_verify($_POST['old_password'], $hash)) {
      echo json_encode(["ok" => false, "message" => "Current password is incorrect."]);
      exit;
   }
   $u = $pdo->prepare("UPDATE users SET password=? WHERE id=?");
   $u->execute([password_hash($_POST['new_password'], PASSWORD_DEFAULT), $id]);
   echo json_encode(["ok" => true, "message" => "Password changed."]);
   exit;
}
echo json_encode(["ok" => false, "message" => "Invalid action."]);
