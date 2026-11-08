<?php
require "../includes/auth.php";
require_role("admin");
require "../config/database.php";
header("Content-Type: application/json");
$a = $_REQUEST['action'] ?? '';

if ($a === 'menu') {
  $s = $pdo->query("SELECT m.*,c.name category FROM menu_items m JOIN categories c ON c.id=m.category_id ORDER BY m.id DESC");
  echo json_encode(["ok" => true, "items" => $s->fetchAll()]);
  exit;
}
if ($a === 'save_menu') {
  $id = (int)($_POST['id'] ?? 0);
  $cat = (int)$_POST['category_id'];
  $name = trim($_POST['name']);
  $desc = trim($_POST['description']);
  $price = (float)$_POST['price'];
  if ($id) {
    $s = $pdo->prepare("UPDATE menu_items SET category_id=?,name=?,description=?,price=? WHERE id=?");
    $s->execute([$cat, $name, $desc, $price, $id]);
  } else {
    $s = $pdo->prepare("INSERT INTO menu_items(category_id,name,description,price) VALUES(?,?,?,?)");
    $s->execute([$cat, $name, $desc, $price]);
  }
  echo json_encode(["ok" => true, "message" => "Menu item saved."]);
  exit;
}
if ($a === 'delete_menu') {
  $s = $pdo->prepare("UPDATE menu_items SET available=0 WHERE id=?");
  $s->execute([(int)$_POST['id']]);
  echo json_encode(["ok" => true]);
  exit;
}
if ($a === 'orders') {
  $s = $pdo->query("SELECT o.*,u.name customer,u.phone FROM orders o JOIN users u ON u.id=o.customer_id ORDER BY o.id DESC");
  echo json_encode(["ok" => true, "orders" => $s->fetchAll()]);
  exit;
}
if ($a === 'order_status') {
  $id = (int)$_POST['id'];
  $status = $_POST['status'];
  $allowed = ['Accepted', 'Rejected', 'Preparing', 'Ready for Pickup'];
  if (!in_array($status, $allowed, true)) {
    echo json_encode(["ok" => false, "message" => "Invalid status"]);
    exit;
  }
  $s = $pdo->prepare("UPDATE orders SET status=? WHERE id=?");
  $s->execute([$status, $id]);
  if ($status === 'Ready for Pickup') {
    $d = $pdo->query("SELECT id FROM users WHERE role='delivery' ORDER BY id LIMIT 1")->fetchColumn();
    if ($d) {
      $x = $pdo->prepare("INSERT INTO delivery_assignments(order_id,delivery_person_id) VALUES(?,?) ON DUPLICATE KEY UPDATE delivery_person_id=VALUES(delivery_person_id),status='Assigned'");
      $x->execute([$id, $d]);
    }
  }
  echo json_encode(["ok" => true]);
  exit;
}
